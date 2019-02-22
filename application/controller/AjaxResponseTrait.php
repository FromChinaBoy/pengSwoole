<?php
namespace Controller;

trait AjaxResponseTrait
{

    protected $responseType = 'json';

    /**
     * ajax请求响应
     * @param int $errorCode
     * @param string $errorMsg
     * @param array $data
     * @return \think\Response
     */
    public function ajaxResponse(int $errorCode, string $errorMsg, array $data = [])
    {
        $responseData = [
            'error_code' => $errorCode,
            'error_msg' => $errorMsg,
        ];
        $data = array_merge($responseData, $data);
        return json_encode($data);
//        return response($data, 200, $header = [], $this->responseType);
    }


    /**
     * 成功响应
     * @param array $data 返回的数据
     * @return \think\Response
     */
    public function successResponse(array $data = [])
    {
        return $this->ajaxResponse(0, '', $data);
    }


    /**
     * 失败响应
     * @param string $errorMsg
     * @param int $errorCode
     * @return \think\Response
     */
    public function failResponse(string $errorMsg, int $errorCode = 1)
    {
        return $this->ajaxResponse($errorCode, $errorMsg);
    }
}
