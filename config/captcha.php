<?php
/**
 * Securimage 验证码通用配置
 * 
 * @author lxp 20160114
 * code_length: 验证文字个数
 * num_lines: 干扰线条数
 * perturbation: 文字扭曲程度 0-1
 */
return [
		'code_length' => 5,
		'image_width' => 120,
		'image_height' => 50,
		'charset' => '23457acefhkmprtvwxy',
		'num_lines' => 2,
		'perturbation' => 0.75
];
