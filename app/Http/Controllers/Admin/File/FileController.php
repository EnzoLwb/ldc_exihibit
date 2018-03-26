<?php
namespace App\Http\Controllers\Admin\File;

use App\Dao\UploadedFileDao;
use App\Dao\UploadedTypeDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Multiupload;
use App\Models\MultiuploadPart;
use App\Models\UploadedFile;
use App\Models\UploadedType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

/**
 * 文件控制器
 *
 * @package App\Http\Controllers\Admin\File
 */
class FileController extends BaseAdminController
{

	// 定义文件状态
	public $fileStatus = [
		0 => '未验证',
		1 => '正常',
		2 => 'OSS导入'
	];

	/**
	 * 文件列表
	 *
	 * @author lxp 20160627
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		// 处理排序
		$sort = request('sort', 'created_at');
		$order = request('order', 'desc');

		$query = UploadedFile::orderBy($sort, $order);
		// 筛选原始文件名
		if (request('file_oldname')) {
			$query->where('file_oldname', 'LIKE', "%" . request('file_oldname') . "%");
		}
		// 筛选添加时间
		if (request('created_at_from')) {
			$query->where('created_at', '>=', request('created_at_from'));
		}
		if (request('created_at_to')) {
			$query->where('created_at', '<=', date('Y-m-d', strtotime(request('created_at_to') . " +1 day")));
		}
		if (request()->has('file_status')) {
			$query->where('file_status', request('file_status'));
		}
		// 取得列表
		$files = $query->paginate(parent::PERPAGE);
		// 将查询参数拼接到分页链接中
		$files->appends(app('request')->all());

		return view('admin.file.file', [
			'files' => $files,
			'fileStatus' => $this->fileStatus
		]);
	}

	/**
	 * 下载文件
	 *
	 * @author lxp 20170206
	 * @param int $file_id 文件id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|\Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function download($file_id)
	{
		$file = UploadedFile::findOrFail($file_id);
		// 处理文件路径
		$filepath = preg_replace('(/+)', '/', public_path($file['file_path'] . '/' . $file['file_name']));
		if (!file_exists($filepath)) {
			return $this->error('文件不存在');
		}

		return response()->download($filepath, $file['file_oldname'], [
			'Content-Type' => $file['file_mime'],
			'Content-Length' => $file['file_size'],
			'Content-Disposition' => 'attachment; filename="' . $file['file_oldname'] . '"'
		]);
	}

	/**
	 * 删除文件
	 *
	 * @author lxp 20160627
	 * @param string $file_ids 文件id，逗号拼接多id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($file_ids)
	{
		$idArray = explode(',', $file_ids);
		// 根据file_id删除表记录及OSS文件
		UploadedFileDao::removeFile($idArray);

		return $this->success('', 's_del');
	}

	/**
	 * 上传图片
	 *
	 * @author lxp 20160629
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function upload()
	{
		if (request()->isMethod('post')) {
			$filefield = 'file';
			UploadedFileDao::saveFile($filefield);

			// TODO 返回信息
		} else {
			return view('admin.file.upload');
		}
	}

	/**
	 * 大文件分片上传
	 *
	 * @author lxp 20170207
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function multiUpload()
	{
		if (request()->isMethod('post')) {
			$fileField = 'file';
			if (Request::hasfile($fileField)) {
				$fileObj = Request::file($fileField);
				if ($fileObj->isValid()) {
					$fileOldName = $fileObj->getClientOriginalName();
					$filePathName = $fileObj->getPathname();

					$filePath = storage_path(env('QUEUE_FILE_PATH', ''));

					$completeMultiUpload = false;
					$hasUpload = false;
					if (request()->has('chunks') && request()->has('chunk')) {
						$fileName = $fileOldName . '.' . request('chunk');

						// 查找分片上传文件
						$mFile = Multiupload::firstOrCreate([
							'name' => $fileOldName,
							'chunks' => request('chunks'),
							'md5' => request('md5')
						]);

						if (file_exists($filePath . '/' . $fileName) && md5_file($filePath . '/' . $fileName) == request('chunkmd5')) {
							$hasUpload = true;
							// 删除临时文件
							@unlink($filePathName);
						} else {
							// 存储分片md5
							MultiuploadPart::firstOrCreate([
								'fid' => $mFile->id,
								'name' => $fileName,
								'chunk' => request('chunk') + 1,
								'md5' => request('chunkmd5')
							]);
						}

						// 判断是否为最后一个分片
						if (request('chunk') + 1 == request('chunks')) {
							$completeMultiUpload = true;
						}
					} else {
						$fileName = $fileOldName;
					}

					// 存本地
					if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
						$fileSaveName = iconv('UTF-8', 'GBK', $fileName);
					} else {
						$fileSaveName = $fileName;
					}
					!$hasUpload && $fileObj->move($filePath, $fileSaveName);

					// 合并文件
					if ($completeMultiUpload) {
						if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
							$fileOldName = iconv('UTF-8', 'GBK', $fileOldName);
						}
						$fp = fopen($filePath . '/' . $fileOldName, "ab");
						for ($i = 0; $i < request('chunks'); $i++) {
							$partFile = $filePath . '/' . $fileOldName . '.' . $i;
							if (file_exists($partFile)) {
								$handle = fopen($partFile, "rb");
								fwrite($fp, fread($handle, filesize($partFile)));
								fclose($handle);
								unlink($partFile);
							}
						}
						fclose($fp);

						// 删除表中碎片记录
						Multiupload::destroy($mFile->id);
						MultiuploadPart::where('fid', $mFile->id)->delete();
					}

					// 将文件转移到指定位置并入库
					$fileFullPath = preg_replace('(/+)', '/', $filePath . '/' . $fileOldName);
					if (file_exists($fileFullPath)) {
						// 取得文件扩展名
						$fileExt = strtolower(pathinfo($fileFullPath, PATHINFO_EXTENSION));
						// 生成随机文件名
						$fileNewName = UploadedFileDao::randomFilename() . '.' . $fileExt;
						// 取得文件MD5
						$fileMd5 = md5_file($fileFullPath);
						// 取得文件大小
						$fileSize = filesize($fileFullPath);
						// 取得文件类型
						$guesser = MimeTypeGuesser::getInstance();
						$fileMime = $guesser->guess($fileFullPath);
						// 取得上传类型相关信息，临时存在通用类型下
						$uType = UploadedTypeDao::getFileType('FT_COMMON');
						// 文件保存路径
						$fileNewPath = env('FILE_PATH', '') . '/' . $uType['path'] . '/' . date('Ymd');
						$fileNewPath = preg_replace('(/+)', '/', $fileNewPath);

						if (env('OSS_UPLOAD')) {
							// 存OSS
						} else {
							// 存本地，将文件转移指定目录
							@mkdir($fileNewPath, 0777, true);
							@rename($fileFullPath, public_path($fileNewPath) . '/' . $fileNewName);
						}

						// 保存数据
						$uploadedFile = new UploadedFile();
						$uploadedFile->file_mime = $fileMime;
						$uploadedFile->file_size = $fileSize;
						$uploadedFile->file_name = $fileNewName;
						$uploadedFile->file_path = $fileNewPath;
						$uploadedFile->file_oldname = $fileOldName;
						$uploadedFile->file_md5 = $fileMd5;
						$uploadedFile->file_status = 1;
						$uploadedFile->uid = Auth::user()->uid;
						$uploadedFile->type_id = $uType['type_id'];
						$uploadedFile->save();
					}
				}
			}
		} else {
			return view('admin.file.multiupload');
		}
	}

	/**
	 * AJAX取得已上传的文件碎片md5
	 *
	 * @author lxp 20160704
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function checkMfile()
	{
		if (request()->ajax()) {
			$mfile = Multiupload::where([
				'name' => request('name'),
				'md5' => request('md5')
			])->with('part')->first();

			$data = [];
			if (!is_null($mfile)) {
				$data = $mfile->part->pluck('md5')->toArray();
			}

			return response()->json($data);
		}
	}

	/**********************************/
	/**********************************/
	/** 以下方法为OSS相关，待需要时完善 **/
	/**********************************/
	/**********************************/

	/**
	 * 录入文件信息，用于oss上传，暂不用
	 *
	 * @author lxp 20160630
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getInfo()
	{
		return view('file/upload_info');
	}

	/**
	 * 保存文件信息
	 *
	 * @author lxp 20160630
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function postInfo()
	{
		if (is_array(request('file_name'))) {
			// 文件保存路径
			$filePath = 'uploadfiles/' . date('Ymd');
			$filePath = preg_replace('(/+)', '/', $filePath);

			// 循环存储文件信息
			foreach (request('file_name') as $k => $file_name) {

				// 检查是否有相同的文件
				if (UploadedFile::where([
						'file_name' => request('file_name')[$k],
						'file_path' => $filePath
					])->count() == 0
				) {
					$uploadedFile = new UploadedFile();
					$uploadedFile->file_mime = request('file_mime')[$k];
					$uploadedFile->file_size = request('file_size')[$k];
					$uploadedFile->file_name = request('file_name')[$k];
					$uploadedFile->file_path = $filePath;
					$uploadedFile->file_oldname = request('file_name')[$k];
					$uploadedFile->file_md5 = request('file_md5')[$k];
					$uploadedFile->uid = Auth::user()->uid;
					$uploadedFile->save();
				}
			}
		}

		// 操作成功，跳转列表
		return $this->showMsg('s_store', [
			[
				'l_back_list',
				url('file/file')
			]
		]);
	}

	/**
	 * 检测文件是否在OSS上
	 *
	 * @author lxp 20160628
	 * @param string $file_ids
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getCheck($file_ids)
	{
		if (request()->ajax()) {
			// 取得所有文件信息
			$fileIdArray = explode(',', $file_ids);
			$files = UploadedFile::findOrFail($fileIdArray);

			foreach ($files as $file) {
				if (env('OSS_UPLOAD')) {
					// 检查文件是否存在
					if (app('oss')->exist($file['file_path'] . '/' . $file['file_name'])) {
						$file->file_status = 1;
						$file->save();
					}
				} else {
					// 本地检测文件是否存在，或者不需要检测 TODO
				}

			}

			return $this->success();
		}
	}

	/**
	 * 游离文件列表，存在于OSS，但未入库的文件
	 *
	 * @author lxp 20160630
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getUnsave()
	{

		$objects = app('oss')->listObjects(request('dir', ''), request('next', ''), parent::PERPAGE);

		// 取得Object列表
		$listObject = $objects->getObjectList();
		// 取得下一页Object索引
		$nextMarker = $objects->getNextMarker();

		$files = [];
		if (is_array($listObject)) {
			foreach ($listObject as $object) {
				$filePath = $object->getKey();
				if (substr($filePath, -1) == '/') {
					continue;
				}

				// 已经存在于表中的数据不显示
				if (UploadedFile::where([
						'file_name' => basename($filePath),
						'file_path' => dirname($filePath)
					])->count() == 0
				) {
					$files[] = $filePath;
				}
			}
		}

		if (empty($files) && $nextMarker != '') {
			// 如果列表为空则直接跳转下一页
			return redirect(url('/file/file/unsave', [
				'next' => $nextMarker,
				'dir' => request('dir', '')
			]));
		} else {
			return view('file/unsave', [
				'files' => $files,
				'nextMarker' => $nextMarker
			]);
		}

	}

	/**
	 * 保存游离文件信息
	 *
	 * @author lxp 20160704
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function postUnsave()
	{
		$objects = request('objects');
		if (is_array($objects)) {
			foreach ($objects as $filePath) {
				if (substr($filePath, -1) == '/') {
					continue;
				}

				$fileInfo = app('oss')->getObjectMeta($filePath);

				if (UploadedFile::where([
						'file_name' => basename($filePath),
						'file_path' => dirname($filePath)
					])->count() == 0
				) {
					UploadedFile::create([
						'file_name' => basename($filePath),
						'file_path' => dirname($filePath),
						'file_mime' => isset($fileInfo['content-type']) ? $fileInfo['content-type'] : '',
						'file_size' => isset($fileInfo['content-length']) ? $fileInfo['content-length'] : 0,
						'file_oldname' => basename($filePath),
						'file_status' => 2,
						'uid' => Auth::user()->uid
					]);
				}

			}

		}

		// 操作成功
		return $this->showMsg('s_store');
	}

	// TODO
	public function getMultiUploadOss()
	{

		set_time_limit(0);
		$file = public_path('temp/445566.zip');
		$filePath = 'uploadfiles/temp/456.zip';
		$fileUploadId = 'C97982F3D0EC41F2BB7FF7D2FCE61B3B';

		// 根据未上传成功的object 查询 uploadid

		// 是否存储uploadid

		// 批量上传，批量匹配

		// 分片上传结合简单上传，用文件大小做判断

		//		dd(app('oss')->listMultipartUploads());
		//		dd(app('oss')->listParts($filePath, $fileUploadId));
		die('go on');

		if (file_exists($file)) {
			app('oss')->multiUpload($filePath, $file, $fileUploadId);
		}
		die('ok');
	}

	/**
	 * 资源上传
	 *
	 * @author yyj 20171016
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function upload_resource()
	{
		return view('admin.file.upload_resource', [

		]);
	}

	/**
	 * 资源上传
	 *
	 * @author yyj 20171016
	 * @param string $uploaded_type 资源类别
	 * @param string $file_id 资源id
	 * @param string $type 显示类别1图片，2非图片
	 * @param int $now_num 已上传数量
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function upload_resource_html($uploaded_type,$file_id,$type,$now_num)
	{
		$info = UploadedType::where('type_key', $uploaded_type)->first();
		$extensions = str_replace('|', ',', $info->allow_type);
		$mimeArray = [];
		$mimeArray['gif'] = 'image/gif';
		$mimeArray['jpg'] = 'image/jpeg';
		$mimeArray['jpeg'] = 'image/jpeg';
		$mimeArray['png'] = 'image/png';
		$mimeArray['xml'] = 'text/xml';
		$mimeArray['svg'] = 'image/svg+xml';
		$mimeArray['xls'] = 'application/vnd.ms-excel';
		$mimeArray['xlsx'] = 'application/vnd.ms-excel';
		$mimeArray['zip'] = 'application/zip';
		$mimeArray['rar'] = 'application/x-rar-compressed';
		$mimeArray['mp3'] = 'audio/mpeg';
		$extensions_arr = explode(',', $extensions);
		foreach ($extensions_arr as $k => $g) {
			$mimeTypes_arr[] = $mimeArray[$g];
		}
		$mimeTypes = implode(',', $mimeTypes_arr);
		$old_allow_num=$info->allow_num;
		if($info->allow_num>1){
			$info->allow_num=$info->allow_num-$now_num;
		}
		return view('admin.file.upload_resource_html', [
			'info' => $info,
			'extensions' => $extensions,
			'mimeTypes' => $mimeTypes,
			'file_id' => $file_id,
			'type' => $type,
			'now_num'=>$now_num,
			'old_allow_num'=>$old_allow_num
		]);
	}
}