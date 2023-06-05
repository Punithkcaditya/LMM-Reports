<?php

namespace App\Controllers;

defined('BASEPATH') or exit('No direct script access allowed');

use App\Controllers\BaseController;
use Config\Database;
class Files extends BaseController
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
        helper('filesystem');
        $this->loadUser();
        $session = session();
        $pot = json_decode(json_encode($session->get("userdata")), true);
        $employee_id = $pot['employee_id'];
        // $directory = '/admin\uploads\doc/*'; 
         $directory = ROOTPATH . 'uploads/doc/*';
        $filenames = glob($directory);
      
        foreach ($filenames as $filename) {
            $file = basename($filename); 
            if (str_contains($file, $employee_id)) {
                $fileNames[]= $file;
            }
        }
          
        $data['fileNames'] = isset($fileNames) ? $fileNames : 0 ;
        $data['session'] = $session;
        $data['title'] = 'Download Files';
        $data['page_heading'] = 'Download Files';
        $data['request'] = $this->request;
        if ($this->permission[0] > 0) {
            $data["link"] = "downloadfiles";
        } else {
            $data["link"] = "#";
        }
        $data["page_heading"] = "Download Files";
        // $data["q"] = $this->admin_users_model->findroles($role_id);
        $data['menuslinks'] = $this
            ->request
            ->uri
            ->getSegment(1);
        $data["view"] = "File/filelisting";
        return view('templates/default', $data);
    }

    public function downloadfiles($filename)
    {
        $this->loadUser();
        $session = session();
        $pot = json_decode(json_encode($session->get("userdata")), true);
        if (empty($pot)) {
            return redirect()->to("/");
        }
        // Load the helper functions for file operations
        helper('filesystem','download');
        // Check if the file exists
        if (!file_exists(ROOTPATH . 'uploads/doc/' . $filename)) {
        // Show a 404 page
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // Set the file path
        $path = ROOTPATH . 'uploads/doc/' . $filename;;
        return $this->response->download($path, null);
}


}