<?php

namespace App\Controllers\movies;

use App\Controllers\BaseController;
use App\Models\UrlModel;
use App\Models\AdsModel;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

/**
 * 
 */
class MovieController extends BaseController
{

    private $urlModel;
    private $base_url;
    private $adsModel;
    private $ads;

    public function __construct()
    {
        $this->urlModel = new UrlModel(); // Load the model
        $this->adsModel = new AdsModel();

        $this->ads = $this->adsModel->findAll();
        // Retrieve data from the database
        $this->base_url = $this->urlModel->first();
    }

    public function index()
    {
        $client = \Config\Services::curlrequest();
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $category_id    = (int) ($this->request->getGet('id'));
        $param = $this->request->getGet('search');
        $param_without_spaces = preg_replace('/\s+/', '', $param);
        if ($param) {
            $url = $this->base_url['base_url'] . "/api.php/provide/vod/?ac=list&wd=" . $param_without_spaces;
        } elseif ($category_id) {
            $url = $this->base_url['base_url'] . "/api.php/provide/vod/?ac=list&t=" . $category_id;
        } else {
            $url = $this->base_url['base_url'] . "/api.php/provide/vod/?ac=list&pg=" . $page;
        }


        $response = $client->request('GET', $url);
        $body = $this->object_to_array(json_decode($response->getBody()));

        $dataset_category = $this->call_category();

        // echo "<pre>";
        // print_r($dataset_category);

        $perPage = 20;
        $total = $body['total'];
        // Call makeLinks() to make pagination links.
        $pager = service('pager');

        $pager_links = $pager->makeLinks($page, $perPage, $total, 'default_full');

        $dataset = [
            'pagetitle' => 'Home',
            'data' => $body,
            'pager_links' => $pager_links,
            'category' => $dataset_category,
            'ads' => $this->ads
        ];

        return view('movies/v_header', $dataset)
            . view('movies/v_home')
            . view('movies/v_footer');
    }
    private function object_to_array($d)
    {
        if (is_object($d))
            $d = get_object_vars($d);

        return is_array($d) ? array_map(__METHOD__, $d) : $d;
    }

    public function showDetails($id)
    {
        $url = $this->base_url['base_url'] . "/api.php/provide/vod/?ac=detail&ids=" . $id;

        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url);

        $body = $this->object_to_array(json_decode($response->getBody()));
        $vod_url = $body['list'][0]['vod_play_url'];
        $parts = explode("#", $vod_url);
        foreach ($parts as &$part) {
            $part = explode("$$$", $part);
        }
        $vod_url_list = array_merge(...$parts);

        $dataset_category = $this->call_category();

        $dataset = [
            'pagetitle' => 'Movie Details',
            'data' => $body,
            'video_urls' => $vod_url_list,
            'category' => $dataset_category,
            'ads' => $this->ads
        ];

        return view('movies/v_header', $dataset)
            . view('movies/v_movie_detail')
            . view('movies/v_footer');
    }
    public function videoPlay($id)
    {

        $url = $this->base_url['base_url'] . "/api.php/provide/vod/?ac=detail&ids=" . $id;

        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url);

        $body = $this->object_to_array(json_decode($response->getBody()));

        $dataset_category = $this->call_category();

        $vod_url = $body['list'][0]['vod_play_url'];
        $parts = explode("#", $vod_url);

        foreach ($parts as &$part) {
            $part = explode("$$$", $part);
        }
        $vod_url_list = array_merge(...$parts);

        $dataset = [
            'pagetitle' => 'Play Videos',
            'data' => $body,
            'video_urls' => $vod_url_list,
            'url' => $this->session->get('_' . $id),
            'category' => $dataset_category,
            'ads' => $this->ads
        ];

        return view('movies/v_header', $dataset)
            . view('movies/v_movie_play')
            . view('movies/v_footer');
    }

    public function play()
    {
        $data = $this->request->getPost('data');
        $id = $this->request->getPost('id');
        $this->session->set('_' . $id, $data);

        echo json_encode($this->request->getPost());
    }


    public function call_category()
    {
        $client = \Config\Services::curlrequest();
        $url = $this->base_url['base_url'] . "/api.php/provide/vod/?ac=list&wd=NoConteNtForThis";
        $response = $client->request('GET', $url);
        $body = $this->object_to_array(json_decode($response->getBody()));
        $dataset_category = [];
        $list = $body['class'];
        foreach ($list as $row) {
            if ($row['type_pid'] == 0) {

                $child = [];
                foreach ($list as $srow) {
                    if ($row['type_id'] == $srow['type_pid']) {
                        $child[] = $srow;
                    }
                }
                $row['child'] = $child;
                $dataset_category[] = $row;
            }
        }
        return $dataset_category;
    }
}
