<?php


if (! function_exists('throwException')) {
    /**
     * @param string $message
     * @param int    $httpCode
     * @param mixed  $result
     *
     * @throws \Minbaby\Umeng\Exception\UmengException
     */
    function throwUmengException($message = '', $httpCode = UMENG_HTTP_DEFAULT, $result = null)
    {
        $exception = new \Minbaby\Umeng\Exception\UmengException($message);
        $exception->setHttpCode($httpCode);
        $exception->setResult($result);

        throw $exception;
    }
}
