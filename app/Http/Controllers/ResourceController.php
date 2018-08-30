<?php
namespace App\Http\Controllers;


use App\Model\Resource;
use Illuminate\Http\Request;
use OSS\OssClient;

class ResourceController
{

    public function fetchResourceList()
    {
        return Resource::orderBy('created_at', 'desc')->take(10)->get();
    }

    function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }

    public function uploader(Request $request)
    {
        $accessKey = 'uA8njzOgNXuDzdbt';
        $accessSecret = 'ECZMiv5NpOoLObgUqcxuCEgoXQH0Cw';
        $client = new OssClient(
            $accessKey,
            $accessSecret,
            "oss-cn-hongkong.aliyuncs.com",
            false
        );

        $expiration = $this->gmt_iso8601(time() + 60 * 60 * 24 * 7);

        $resource = Resource::create([
            'discriminator' => 'video',
            'title' => $request->json('raw_name', '123.png'),
            'status' => 'uploading',
            'mime_type' => $request->json('mime_type'),
            'size' => $request->json('size'),
            'description' => $request->json('description', '')
        ]);

        $objectPath = "resources/{$resource->id}.png";

        $policy = base64_encode(
                json_encode([
                    'expiration' => $expiration,
//                    'conditions' => [
//                        [
//                            'content-length-range',
//                            0,
//                            1048576000
//                        ],
//                        [
//                            'starts-with',
//                            $accessKey,
//                            'resources'
//                        ]
//                    ]
            ])
        );

        $signature = base64_encode(
            hash_hmac(
                'sha1',
                $policy,
                $accessSecret,
                true
            )
        );

        return [
            'signature' => $signature,
            'policy' => $policy,
            'access_key' => $accessKey,
            'upload_url' => "http://open-edu.oss-cn-hongkong.aliyuncs.com", // $client->signUrl('open-edu', $objectPath)
            'resource' => $resource,
            'object_path' => $objectPath
        ];
    }

    public function changeStatus(int $id, Request $request)
    {
        $resource = Resource::find($id);
        $resource->status = $request->get('status');
        $resource->save();

        return $resource;
    }
}