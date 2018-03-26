<?php

namespace App\Dao;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
//use OSS\Core\OssException;
use Illuminate\Support\Facades\Request;
use App\Models\UploadedFile;

/**
 * 上传文件业务模型
 *
 * @author lxp 20160627
 */
class UploadedFileDao extends UploadedFile
{

	/**
	 * 上传文件并保存
	 *
	 * @author lxp 20160627
	 * @param string $fileField 文件资源名称
	 * @param string $typeKey 文件类型键值
	 * @param int $item_id 文件对应的模型条目id，例如文章id，商品id等
	 * @param string $fileName 自定义保存的文件名
	 * @return array
	 */
	public static function saveFile($fileField, $typeKey = 'FT_COMMON', $item_id = 0, $fileName = '')
	{
		if (Request::hasfile($fileField)) {
			$fileObj = Request::file($fileField);
			if (is_array($fileObj)) {
				// 数组附件处理
			} else {
				return self::saveFileObj($fileObj, $typeKey, $item_id, $fileName);
			}
		}
		return self::returnData(trans('uploadfile.error_nofile'));
	}

	/**
	 * 上传文件并保存
	 *
	 * @author lxp 20170906
	 * @param object $fileObj 文件资源对象
	 * @param string $typeKey 文件类型键值
	 * @param int $item_id 文件对应的模型条目id，例如文章id，商品id等
	 * @param string $fileName 自定义保存的文件名
	 * @return array
	 */
	public static function saveFileObj($fileObj, $typeKey = 'FT_COMMON', $item_id = 0, $fileName = '')
	{
		if ($fileObj->isValid()) {
			$fileExt = strtolower($fileObj->getClientOriginalExtension());
			$fileSize = $fileObj->getClientSize();
			$fileMime = $fileObj->getMimeType();
			$fileOldName = $fileObj->getClientOriginalName();
			$filePathName = $fileObj->getPathname();
			// 取得文件MD5
			$fileMd5 = md5_file($filePathName);

			// 取得上传类型相关信息
			$uType = UploadedTypeDao::getFileType($typeKey);
			if (!$uType) {
				return self::returnData('utype is not exists');
			}
			// 验证文件类型
			if ($uType['allow_type'] && !in_array($fileExt, explode('|', $uType['allow_type']))) {
				return self::returnData(trans('uploadfile.error_filetype'));
			}
			// 验证文件大小
			if ($uType['allow_size'] && $fileSize > $uType['allow_size']) {
				$size = $uType['allow_size']/1024/1024;
				return self::returnData(trans('uploadfile.error_filesize',['size' => $size]));
			}

			// 文件名
			if ($fileName == '') {
				$fileName = self::randomFilename();
			}
			$fileName .= '.' . $fileExt;

			// 文件保存路径
			$filePath = env('FILE_PATH', '') . '/' . $uType['path'] . '/' . date('Ymd');
			$filePath = preg_replace('(/+)', '/', $filePath);

			if (env('OSS_UPLOAD')) {
				// 取得文件资源
				$fileContent = file_get_contents($filePathName);
				// 存OSS
				try {
					app('oss')->upload($filePath . '/' . $fileName, $fileContent);
				} catch (OssException $e) {
					return self::returnData($e->getMessage());
				}
			} else {
				// 存本地
				$fileObj->move(public_path($filePath), $fileName);
			}

			// 保存数据
			$uploadedFile = new UploadedFile();
			$uploadedFile->file_mime = $fileMime;
			$uploadedFile->file_size = $fileSize;
			$uploadedFile->file_name = $fileName;
			$uploadedFile->file_path = $filePath;
			$uploadedFile->file_oldname = $fileOldName;
			$uploadedFile->file_md5 = $fileMd5;
			$uploadedFile->file_status = 1;
			if (Auth::check()) {
				$uploadedFile->uid = Auth::user()->uid;
			}
			$uploadedFile->type_id = $uType['type_id'];
			$uploadedFile->item_id = $item_id;
			$uploadedFile->save();

			return self::returnData($uploadedFile, true);
		} else {
			return self::returnData($fileObj->getErrorMessage());
		}
	}

	/**
	 * 保存远程文件
	 *
	 * @author lxp 20170915
	 * @param string $fileurl
	 * @param string $typeKey
	 * @param int $item_id
	 * @param string $fileName
	 * @return array
	 */
	public static function saveRemoteFile($fileurl, $typeKey = 'FT_COMMON', $item_id = 0, $fileName = '')
	{
		if (!m_file_exists($fileurl)) {
			return self::returnData('remote file not exists');
		}

		// 取得上传类型相关信息
		$uType = UploadedTypeDao::getFileType($typeKey);
		if (!$uType) {
			return self::returnData('utype is not exists');
		}

		// 扩展名
		$fileExt = pathinfo($fileurl, PATHINFO_EXTENSION);
		if (!$fileExt && in_array('jpg', explode('|', $uType['allow_type']))) {
			$fileExt = 'jpg';
		}
		// 验证文件类型
		if ($uType['allow_type'] && !in_array($fileExt, explode('|', $uType['allow_type']))) {
			return self::returnData(trans('uploadfile.error_filetype'));
		}

		// 文件名
		if ($fileName == '') {
			$fileName = self::randomFilename();
		}
		$fileName .= '.' . $fileExt;
		// 文件保存路径
		$filePath = env('FILE_PATH', '') . '/' . $uType['path'] . '/' . date('Ymd');
		$filePath = preg_replace('(/+)', '/', $filePath);
		$fileFullPath = public_path($filePath) . '/' . $fileName;
		// 循环创建目录
		if (!is_dir(dirname($fileFullPath))) {
			mkdir(dirname($fileFullPath), 0755, true);
		}

		// 取得文件资源并保存
		$client = new Client(['verify' => false]);
		$client->get($fileurl, ['save_to' => $fileFullPath]);
		// 计算文件大小
		$fileSize = @filesize($fileFullPath);

		// 保存数据
		$uploadedFile = new UploadedFile();
		$uploadedFile->file_size = $fileSize;
		$uploadedFile->file_name = $fileName;
		$uploadedFile->file_path = $filePath;
		$uploadedFile->file_status = 1;
		if (Auth::check()) {
			$uploadedFile->uid = Auth::user()->uid;
		}
		$uploadedFile->type_id = $uType['type_id'];
		$uploadedFile->item_id = $item_id;
		$uploadedFile->save();

		return self::returnData($uploadedFile, true);
	}

	/**
	 * 生成随机文件名
	 *
	 * @author lxp
	 * @return string
	 */
	public static function randomFilename()
	{
		$seedstr = explode(" ", microtime(), 5);
		$seed = $seedstr[0] * 10000;
		srand($seed);
		$random = rand(1000, 10000);

		return date("YmdHis", time()) . $random;
	}

	/**
	 * 删除附件
	 *
	 * @author lxp 20160705
	 * @param array|int $fileIdArray
	 */
	public static function removeFile($fileIdArray)
	{
		// 取得所有文件信息
		$files = UploadedFile::find($fileIdArray);
		if ($files != null) {
			// 处理数据
			$filePathArray = [];
			foreach ($files as $file) {
				array_push($filePathArray, $file['file_path'] . '/' . $file['file_name']);
			}

			if (env('OSS_UPLOAD')) {
				// 删除OSS文件
				app('oss')->delete($filePathArray);
			} else {
				// 删除本地文件
				foreach ($filePathArray as $filePath) {
					@unlink(public_path($filePath));
				}
			}

			// 删除
			UploadedFile::destroy($fileIdArray);
		}
	}

	/**
	 * 根据附件类型及条目id删除附件
	 *
	 * @author lxp 20170302
	 * @param int|array $item_id 条目id
	 * @param int $type_key 附件类型键名
	 */
	public static function removeFileByItem($item_id, $type_key)
	{
		// 取得附件类型id
		$type = UploadedTypeDao::getFileType($type_key);
		if ($type['type_id']) {
			$fileIdArray = [];
			// 取得要删除的附件id
			if (is_array($item_id)) {
				$fileIdArray = UploadedFile::where('type_id', $type['type_id'])->whereIn('item_id', $item_id)->get()->pluck('file_id')->all();
			} elseif (intval($item_id)) {
				$fileIdArray = UploadedFile::where('type_id', $type['type_id'])->where('item_id', $item_id)->get()->pluck('file_id')->all();
			}
			// 删除附件
			self::removeFile($fileIdArray);
		}
	}

	/**
	 * 返回数据
	 *
	 * @author lxp 20160712
	 * @param object|string $data 附件对象或错误信息
	 * @param bool $status 状态
	 * @return array
	 */
	private static function returnData($data, $status = false)
	{
		return [
			'status' => $status,
			'data' => $data
		];
	}

}
