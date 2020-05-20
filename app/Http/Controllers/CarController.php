<?php

namespace App\Http\Controllers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OSS\Core\OssException;
use OSS\OssClient;

class CarController extends Controller
{

    private $accessKeyId;
    private $accessSecret;

    public function __construct()
    {
        $this->accessKeyId = env('ACCESSKEYID');
        $this->accessSecret = env('ACCESSSECRET');

    }

    public function show()
    {
        return view('car');
    }

    public function uploadImage(Request $request)
    {
        //将文件存放本地
        $image1 = $request->file('file1')->store('public/images');
        $image2 = $request->file('file2')->store('public/images');
        $image3 = $request->file('file3')->store('public/images');
        $imageArr = array($image1, $image2, $image3);
        $acl = 'public-read-write';
        $arr = array();
        $action = '';
        foreach ($imageArr as $k => $image) {
            if ($k == 0) {
                $action = 'RecognizeLicensePlate';
            } elseif ($k == 1) {
                $action = 'RecognizeDriverLicense';
            } else if ($k == 2) {
                $action = 'RecognizeDrivingLicense';
            }
            //得到storage/images/文件名

            $arr[$k]['url'] = Storage::url($imageArr[$k]);
            //得到文件名
            $arr[$k]['filename'] = Str::after($arr[$k]['url'], '/storage/images/');
            //获取绝对路径
            $arr[$k]['absolutePath'] = "/Users/hermit/Desktop/PHP_Code/idCardOcr/storage/app/public/images/" . $arr[$k]['filename'];

            try {
                $ossClient = new OssClient($this->accessKeyId, $this->accessSecret, env('END_POINT'));
                $ossClient->uploadFile(env('BUCKET'), $arr[$k]['filename'], $arr[$k]['absolutePath']);
                $ossClient->putObjectAcl(env('BUCKET'), $arr[$k]['filename'], $acl);
                $arr[$k]['ossUrl'] = $this->getOssUrl($arr[$k]['filename']);
                $arr[$k]['result'] = $this->recognition($arr[$k]['ossUrl'], $action);

            } catch (OssException $e) {
            }


        }
        return view('carResult')->with(
            [
                'LicensePlate' => $arr[0],
                'DriverLicense' => $arr[1],
                'DrivingLicense' => $arr[2]
            ]
        );
//        return response()->json([
//            'LicensePlate' => $arr[0],
//            'DriverLicense' => $arr[1],
//            'DrivingLicense' => $arr[2]
//        ],200);


    }

    public function getOssUrl($filename)
    {
        //获取url
        try {
            $ossClient = new OssClient($this->accessKeyId, $this->accessSecret, env('END_POINT'));
            //得到的ossUrl
            $url = $ossClient->signUrl(env('BUCKET'), $filename, 1000);
            //返回oss中图片url
            return $url;
        } catch (OssException $e) {
            print $e->getMessage();
        }
    }


    public function recognition($imgUrl, $action)
    {
        try {
            AlibabaCloud::accessKeyClient($this->accessKeyId, $this->accessSecret)
                ->regionId('cn-shanghai')
                ->asDefaultClient();
        } catch (ClientException $e) {
            printf($e->getMessage());
        }

        try {
            if ($action == 'RecognizeLicensePlate') {
                $result = AlibabaCloud::rpc()
                    ->product('ocr')
                    ->scheme('https') // https | http
                    ->version('2019-12-30')
                    ->action('RecognizeLicensePlate')
                    ->method('POST')
                    ->host('ocr.cn-shanghai.aliyuncs.com')
                    ->options([
                        'query' => [
                            'RegionId' => "cn-shanghai",
                            'ImageURL' => $imgUrl,
                        ],
                    ])
                    ->request();
                return $result['Data'];
            } elseif ($action == 'RecognizeDriverLicense'|| $action == 'RecognizeDrivingLicense') {
                $result = AlibabaCloud::rpc()
                    ->product('ocr')
                    ->scheme('https') // https | http
                    ->version('2019-12-30')
                    ->action('RecognizeDriverLicense')
                    ->method('POST')
                    ->host('ocr.cn-shanghai.aliyuncs.com')
                    ->options([
                        'query' => [
                            'RegionId' => "cn-shanghai",
                            'ImageURL' => $imgUrl,
                            'Side' => 'face'
                        ],
                    ])
                    ->request();
                return $result['Data'];
            }
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }


    }
}
