<?php

namespace App\Controllers;

defined('BASEPATH') or exit('No direct script access allowed');

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\HTTP\Files\ZipHandler;
class BulkuploadController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::connect();
        $request = \Config\Services::request();
        helper(['form', 'url', 'string']);
        $session = session();
        $pot = json_decode(json_encode($session->get("userdata")), true);
        if (empty($pot)) {
            return redirect()->to("/");
        } else {
            $role_id = $pot["role_id"];
        }
        $menutext = $this->request->uri->getSegment(2);
        if (isset($_SESSION['sidebar_menuitems'])) {
            foreach ($_SESSION['sidebar_menuitems'] as $main_menus):
                if (strtolower($main_menus->menuitem_link) == strtolower($menutext)) {
                    $permissions = $this->admin_roles_accesses_model->get_permisions($role_id, $main_menus->menuitem_id);
                    $this->permission = array($permissions->add_permission, $permissions->edit_permission, $permissions->delete_permission);
                } else {
                    if (!empty($main_menus->submenus)):
                        foreach ($main_menus->submenus as $submenus):
                            if (strtolower($submenus->menuitem_link) == strtolower($menutext)) {
                                $permissions = $this->admin_roles_accesses_model->get_permisions($role_id, $submenus->menuitem_id);
                                $this->permission = array($permissions->add_permission, $permissions->edit_permission, $permissions->delete_permission);
                            }
                        endforeach;
                    endif;
                }
            endforeach;
        }
    }

    public function index()
    {
        $this->loadUser();
        $session = session();
        $pot = json_decode(json_encode($session->get("userdata")), true);
        if (empty($pot)) {
            return redirect()->to("/");
        }
        $data['session'] = $session;
        $data['title'] = 'Upload Files';
        $data['page_heading'] = 'Add New User';
        $data['request'] = $this->request;
        $data["link"] = "#";
        $data['menuslinks'] = $this
            ->request
            ->uri
            ->getSegment(1);
        $data["view"] = "File/fileupload";
        return view('templates/default', $data);
    }

    public function upload()
    {
        $this->loadUser();
        $session = session();
        $pot = json_decode(json_encode($session->get("userdata")), true);
        if (empty($pot)) {
            return redirect()->to("/");
        }
        if ($this->request->getMethod() == "post") {     
    $zipFile = $this->request->getFile('zipfile');
    if ($zipFile->isValid() && $zipFile->getExtension() == 'zip') {
        $zipFile->move(ROOTPATH . 'uploads/doc', $zipFile->getName());
        $filename = ROOTPATH . 'uploads/doc/'.$zipFile->getName();
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $oldfolder = ROOTPATH . 'uploads/doc/'.$basename;
        $parentFolder = dirname($filename);
        $zip = new \ZipArchive;
        $res = $zip->open($filename);
        if ($res === true) {
            $path = ROOTPATH . 'uploads/doc';
            $zip->open($filename, \ZipArchive::CREATE);
            $zip->extractTo($path);
            $zip->close();
            // $allfiles = glob($oldfolder);
            shell_exec("mv $oldfolder/* $parentFolder/ && rm -R  $oldfolder");
            unlink($filename);
            $this->session->setFlashdata('success',"File Uploaded successfully.");  
        } else {
            $this->session->setFlashdata('error',"failed to upload $filename!");            
        }
    }  
    }
    return redirect()->to('bulkupload');
}

public function fileupload(){
    $this->loadUser();
    $session = session();
    $pot = json_decode(json_encode($session->get("userdata")), true);
    if (empty($pot)) {
        return redirect()->to("/");
    }
   $data['admin_users'] =  $this->admin_users_model->where("created_by= '{$pot['user_id']}'")
    ->orderBy("user_id", "ASCE")
    ->findAll();
    $data['session'] = $session;
    $data['title'] = 'Upload Files';
    $data['page_heading'] = 'Add New User';
    $data['request'] = $this->request;
    $data["link"] = "#";
    $data['menuslinks'] = $this
        ->request
        ->uri
        ->getSegment(1);
    $data["view"] = "File/userfileupload";
    return view('templates/default', $data);
}

public function singleupload(){ 
    $this->loadUser();
    $session = session();
    $pot = json_decode(json_encode($session->get("userdata")), true);
    if (empty($pot)) {
        return redirect()->to("/");
    }
  

    if ($this->request->getMethod() == "post") { 
        $admin_users = $this->request->getPost('admin_users');
        $uploaded_file = $this->request->getFile('userfile');
        if ($uploaded_file->isValid() && !$uploaded_file->hasMoved())
        { 
            // $profile_pic = $uploaded_file->getName();
            $randomName = uniqid();
            $ext = $uploaded_file->getClientExtension();
            $name= $uploaded_file->getRandomName();
            $namewitoutext = substr($name, 0, strpos($name, ".")); // remove the extension
            $filename =  $admin_users ."_". $namewitoutext.".".$ext;
            $uploaded_file->move(ROOTPATH . 'uploads/doc', $filename);
            $this->session->setFlashdata('success',"File Uploaded successfully."); 
        }
        else
        {
            $this->session->setFlashdata('error',"Unable to upload the file");  
        }
        return redirect()->to('fileupload');
    }
}
}