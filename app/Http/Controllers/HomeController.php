<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use phpseclib3\Crypt\DSA;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\File\ASN1\Maps\DSAPublicKey;


class HomeController extends Controller
{
    /**
     *  Проверка выбранной функции
     * 
     * @param $request Request Параметры, переданные в теле POST запрооса
     */
    public function dsa(Request $request){

        if($request->post('button') == 'create'){
            $this->create($request);
        }

        if($request->post('button') == 'verify'){
            $this->verify($request);
        }

    }
    
    /**
     *  Вычисление цифровой подписи
     * 
     * @param $request Request Параметры, переданные в теле POST запрооса
     */
    public function create(Request $request){

        //Проверка исходных данных
        if($request->post('src_file') == '' || 
        $request->post('dsa_file') == '' ||
        $request->post('key_file') == ''){

            // Редирект на главную страницу
            return redirect('/');
        }

        //Инициализация переменных
        $src_file = $request->post('src_file');
        $dsa_file = $request->post('dsa_file').'.sig';
        $key_file = $request->post('key_file').'.pub';

        //Проверка существования файлов
        if(!file_exists($src_file)){
            // Редирект на главную страницу
            return redirect('/');
        }

        $src = file_get_contents($src_file);

        //Создание пары ключей
        $private_key = DSA::createKey();
        $public_key = $private_key->getPublicKey();

        //Сохранение открытого коюча в файл
        file_put_contents($key_file, $public_key);

        //Вычисление ЭЦП
        $signature = $private_key->sign($src);

        //Сохранение ЭЦП в файл
        file_put_contents($dsa_file, $signature);

        echo 'Файл подписан';
    }

    /**
     *  Проверка цифровой подписи
     * 
     * @param $request Request Параметры, переданные в теле POST запрооса
     */
    public function verify(Request $request){
        //Проверка исходных данных
        if($request->post('src_file') == '' || 
        $request->post('dsa_file') == '' ||
        $request->post('key_file') == ''){

            // Редирект на главную страницу
            return redirect('/');
        }


        //Инициализация переменных
        $src_file = $request->post('src_file');
        $dsa_file = $request->post('dsa_file').'.sig';
        $key_file = $request->post('key_file').'.pub';

        $src = file_get_contents($src_file);
        $key = file_get_contents($key_file);
        $dsa = file_get_contents($dsa_file);

        //Проверка существования файлов
        if(!file_exists($src_file) ||
        !file_exists($dsa_file) ||
        !file_exists($key_file)){
            // Редирект на главную страницу
            return redirect('/');
        }

        //Импорт открытого ключа
        $public_key = DSA::loadPublicKey($key);

        //Проверка ЭЦП
        $verivy = $public_key->verify($src, $dsa);

        echo $verivy ? 'Подпись верна!' : 'Подпись неверна!';



    }



}
