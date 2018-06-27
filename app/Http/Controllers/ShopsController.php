<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use \App\Shop;

use Illuminate\Http\Request;

  class ShopsController extends Controller
  {
    const API_URL = "https://api.gnavi.co.jp/RestSearchAPI/20150630/";
    const API_KEY  = 'bdd9ac1da76074e8adb28cc22dc07ce6';
    const API_NUM = 30;
    const API_SORT = null;
    const API_FORMAT = 'json';
    
    
    function __construct() {
    }
    
    function search($input, $count = self::API_NUM, $sort = self::API_SORT) {

        $lists = [];

        $url = sprintf('%s?keyid=%s', self::API_URL, self::API_KEY);

        $param = [
            'format' => self::API_FORMAT,
            'hit_per_page' => $count,
        ];
        if (!empty($input['keyword'])) {
          $param['freeword'] = $input['keyword'];
          $param['freeword_condition'] = 2;
        }
        
    
        
        foreach ($param as $key => $value) {
            $url .= '&' . $key . '=' . $value;
        }
        

        $json = @file_get_contents($url);

        $data = json_decode($json, true);
        if ($data === false) {
            return $lists;
        }
        $rest = [];
        if ($data['total_hit_count'] == 0) {
            return $lists;
        } else if ($data['total_hit_count'] == 1) {
            $rest[] = $data['rest'];
        } else {
            $rest = $data['rest'];
        }

 
         foreach ($rest as $item) {
            $tmp = [];

            // 店舗名
            $tmp['name'] = !empty($item['name']) ? $item['name'] : '';
            $tmp['name_kana'] = !empty($item['name_kana']) ? $item['name_kana'] : '';
                        // 店舗画像(1枚だけ取得する)
            $tmp['image_url'] = '';
            for ($i = 1; $i <= 2; $i++) {
                if (!empty($item['image_url']['shop_image' . $i])) {
                    $tmp['image_url'] = $item['image_url']['shop_image' . $i];
                    break;
                }
            
            }
            $tmp['url'] = !empty($item['url']) ? $item['url'] : '';
         
             $lists[] = $tmp;
         }
         
         return $lists;
    }

    public function create(Request $request)
    {   
        $keyword = $request->keyword;
        $lists= [];
        
        if ($keyword){
   
            $lists = $this->search($request);
        }
        return view('shops.create', [
            'keyword' => $keyword,
            'lists' => $lists,
        ]);
    }
  }