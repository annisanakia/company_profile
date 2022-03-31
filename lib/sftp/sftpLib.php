<?php

namespace Lib\sftp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;

class sftpLib extends Controller{
    public function connect(){  
        $adapter = new SftpAdapter([
            'host' => 'images.hsp.co.id',
            'port' => 447,
            'username' => 'root',
            'password' => '1gl0b4lp3rs4d4',
            'privateKey' => '',
            'root' => '/var/www/html/hsp_asset',
            'timeout' => 10,
            'directoryPerm' => 0755
        ]);

        return new Filesystem($adapter);
    }
} 