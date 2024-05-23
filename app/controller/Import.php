<?php

namespace app\controller;
use flundr\mvc\Controller;
use flundr\auth\Auth;
use flundr\utility\Session;

class Import extends Controller {

	public function __construct() {
		if (!Auth::logged_in() && !Auth::valid_ip()) {Auth::loginpage();}		
		$this->view('DefaultLayout');
		$this->models('Scrape,RSS_Adapter,Json_Adapter,BNNTickerAdapter,BNNArticleAdapter,FileReader');
	}

	public function article() {

		$content = $this->BNNArticleAdapter->get($_POST['url']);

		if (is_null($content)) {
			$this->view->json(['content' => 'keine Artikeldaten gefunden']);
			die;
		}

		// Removes HTML Tags and multiple lines and spaces
		$content = strip_tags($content);
    	$content = preg_replace('/\n\s*\n+/', "\n", $content);
	    $content = preg_replace('/ {2,}/', ' ', $content);
	    $content = trim($content);

		$data['content'] = $content;
		$this->view->json($data);
	}

	public function ticker($id) {
		$ticker = $this->BNNTickerAdapter->get_by_id($id);
		$data['content'] = implode(" ",$ticker);
		$this->view->json($data);
	}

	public function pdf() {
		$this->view->render('upload');
	}

	public function file_upload() {
		$output = $this->FileReader->import($_FILES['file']);
		echo $output;
	}

	public function splitter() {

		$files = [];

		$ff = 'ffmpeg'; // command to open ffmpeg
		$outDir = PUBLICFOLDER . 'audio/';

		if ($_FILES) {

			$tmp_file = $_FILES['audio']['tmp_name'];
			$in = $tmp_file;
			
			if (!file_exists($outDir)) {mkdir($outDir, 0777, true);}
			array_map('unlink', array_filter((array) glob($outDir.'*')));
			echo shell_exec("$ff -i $in -f segment -segment_time 300 -c copy ".$outDir."splitted%03d.mp3");	
		}

		if (file_exists($outDir)) {
			$files = scandir($outDir, SCANDIR_SORT_ASCENDING);
			$files = array_diff($files, array('.', '..'));
		}

		$this->view->files = $files;	
		$this->view->render('audiosplitter');

	}

}
