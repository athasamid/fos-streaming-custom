<?php
include('config.php');
logincheck();

$message = [];
$title = "Create stream";
$stream = new Stream;
$categories = Category::all();
$transcodes = Transcode::all();

if(isset($_GET['id'])) {
    $title = "Edit stream";
    $stream = Stream::find( $_GET['id']);
}

if (isset($_POST['submit'])) {
    $stream->name = $_POST['name'];
    $stream->streamurl = $_POST['streamurl'];
    $stream->cat_id = $_POST['category'];
    $stream->trans_id = $_POST['transcode'];
    $stream->streamurl2 = $_POST['streamurl2'];
    $stream->streamurl3 = $_POST['streamurl3'];
    $stream->tvid = $_POST['tvid'];
    $stream->logo = $_POST['logo'];
    $stream->bitstreamfilter = 0;
    if(isset($_POST['bitstreamfilter'])) {
        $stream->bitstreamfilter = 1;
    }

    if (empty($_POST['name'])) {
        $message['type'] = "errorr";
        $message['message'] = "O campo Nome está vazio";
    }
    else if (empty($_POST['streamurl'])) {
        $message['type'] = "errorr";
        $message['message'] = "streamurl está vazia";
    }
    else if (empty($_POST['category'])) {
        $message['type'] = "errorr";
        $message['message'] = "Selecione uma categoria";
    } else {

        if(isset($_GET['id'])) {
            $message['type'] = "Sucesso";
            $message['message'] = "Stream salva";
            $stream->save();
        } else {
            $exists = Stream::where('name', '=', $_POST['name'])->get();

            if(count($exists) > 0) {
                $message['type'] = "errorr";
                $message['message'] = "streamname ja esta em uso";
            } else {
                $message['type'] = "success";
                $message['message'] = "Stream criada";
                $stream->save();
                redirect("manage_stream.php?id=" . $stream->id, 1000);
            }
        }
    }
}

echo $template->view()->make('manage_stream')
    ->with('stream',  $stream)
    ->with('categories',  $categories)
    ->with('transcodes',  $transcodes)
    ->with('message', $message)
    ->with('title', $title)
    ->render();
