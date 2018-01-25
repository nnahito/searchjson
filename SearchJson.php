<?php


/**
 * JsonSearchクラス
 *
 * Jsonを深掘りして、様々な探索を行います
 *
 */
class JsonSearch
{

    /**
     * 与えられたJson文字列をPHPの配列に直したものを入れておく変数
     * @var array
     */
    private $array;


    /**
     * コンストラクタ
     * いずれここから始まっていく
     *
     * @param  string     $json 探索したいJSONデータ
     * @access public
     * @author <nnahito> Nな人
     * @since  2018-01-25
     */
    public function __construct(string $json) {

        // JSON文字列をPHPの配列に変換する
        $this->array = json_decode($json, true);

    }



    /**
     * JSONを、配列の「キー」をベースに探索し、その結果の値を配列にして返します
     *
     * @param  string     $search_key       検索したいキーの値
     * @return array                        結果の値
     * @access public
     * @author <nnahito> Nな人
     * @since  2018-01-25
     */
    public function searchJsonByKey(string $search_key) :array {

        // 結果を入れておく変数
        $result = [];

        // 配列のループ開始
        foreach ($this->array as $key => $value) {

            // キーが一致するかの確認
            if ( (string)$key === $search_key ) {

                // 一致したらその値を配列に入れる
                $result[] = $value;

            } else {

                // 一致しなかった場合、その値が配列かどうかを見る
                if ( is_array($value) === true ) {

                    // 配列であった場合、更に再帰的にその値を探しに行く
                    $json_search = new JsonSearch(json_encode($value));
                    $temp = $json_search->searchJsonByKey($search_key);

                    // 返ってきた値をフラットにする
                    foreach ($temp as $k => $v) {
                        $result[] = $v;
                    }

                }
            }
        }

        // 結果を返す
        return $result;

    }


}
