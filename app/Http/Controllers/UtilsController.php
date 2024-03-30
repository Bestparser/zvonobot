<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilsController extends Controller
{

    public static function test(Request $request) {
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET', 'https://api.github.com/user', [
            'auth' => ['user', 'pass']
        ]);
        echo $res->getStatusCode();
        // "200"
        echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        echo $res->getBody();
        // {"type":"User"...'

        // Send an asynchronous request.
        $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
        $promise = $client->sendAsync($request)->then(function ($response) {
            echo 'I completed! ' . $response->getBody();
        });
        $promise->wait();

        return 0;
    }

    public static function Scroll(Request $request, $rows_all) {
		$page = [];

		$row_cnt = 25;
		$offset = 0;
		$current = 1;

		if ($request->has('page')) {
			$current = (int) $request->page;
		}

		$page['prev'] = null;
		$page['next'] = null;

		if ($rows_all > $row_cnt){
			$offset = ($current-1)*$row_cnt;
			if ($current == 1) {
				$page['prev'] = null;
				$page['next'] = $current+1;
 		    }

			if ($current > 1) {
				$page['prev'] = $current-1;
				$page['next'] = $current+1;
			}

			if (($offset+$row_cnt) > $rows_all){
				$page['next'] = null;
			}
		}

		$page['current'] = $current;
		$page['rows_all'] = $rows_all;
		$page['row_cnt'] = $row_cnt;
		$page['offset'] = $offset;


		return $page;
	}
}
