<?php
/**
 * Created by Tyfix 2015
 */
include('config.php');
logincheck();
$message = [];

if (isset($_GET['delete'])) {
    if ($_GET['delete'] == 1) {
        $message['type'] = "error";
        $message['message'] = "Não é possível remover a conta do administrador principal";
    } else {
        $admin = Admin::find($_GET['delete']);
        $admin->delete();

        $message['type'] = "Successo";
        $message['message'] = "Administrador deletado com sucesso";
    }
}

$admins = Admin::all();

echo $template->view()->make('admins')
    ->with('admins', $admins)
    ->with('message', $message)
    ->render();
