<?php

// set error reporting level
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE);

function bytesToSize1024($bytes, $precision = 2) {
    $unit = array('B','KB','MB');
    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
}

if (isset($_FILES['myfile'])) { 
    $sFileName = $_FILES['myfile']['name'];
    $sFileType = $_FILES['myfile']['type'];
    $sFileSize = bytesToSize1024($_FILES['myfile']['size'], 1);
/*    echo <<<EOF
<div class="s">
    Your file: {$sFileName} has been successfully received.<br/>
    Type: {$sFileType}<br/>
    Size: {$sFileSize}<br/>
</div>
EOF;*/
} else {
    echo '<div class="f">An error occurred</div>';
}

    //declare upload既資料夾
    $myusername = $_COOKIE["name"];
    $Move = 'upload/'.$myusername.'/';
    //判斷檔案名稱既function 會return 0 1 2
    function inspect_file($strFileName, $intFileSize)
    {
        //declare可上傳的副檔名
        $subsidiary_filename = array('JPG','JPEG','GIF','PNG','TXT','JAVA','ZIP','DOCX','DOC','PDF');
        //declare可上傳大小
        $FILE_SIZES_max = 104857600;  //100Megabytes in bytes
        $FILE_SIZES_min = 0;

        $arrSm =  preg_split("/[.]+/", $strFileName);
        //fetch最後一個array
        $strEt = $arrSm[count($arrSm) - 1];
        //判斷符唔符合以上FILE_TYPES中所declare既檔案名稱
        for ($s=0;$s < count($subsidiary_filename);$s++){
            if (strtoupper($strEt) == $subsidiary_filename[$s]){
                return 0;
            }
        }
        //判斷檔案大小有無過大
        if ($intFileSize < $FILE_SIZES_min || $intFileSize > $FILE_SIZES_max){
            return 2;
        }
        return 1;
    }
    
    //將上傳的名稱同檔案大小放入inspect_file做判斷(然後return 0 , 1 ,2) #參考上面個function
    $intInspectResult = inspect_file($_FILES['myfile']['name'], $_FILES['myfile']['size']);
    //echo $_FILES['myfile']['tmp_name'] . "<br/>";
    $sFileType = $_FILES['myfile']['type'];
    if ($intInspectResult == 1)
    {
        //echo "對不起，您的檔案上傳失敗，因為上傳的是不被允許的檔案類型";  
        if ($sFileType == "application/octet-stream")
        {
            echo "Ops, file type RAR is not prohibited, please upload with .zip extension.";
        } else
            echo "Ops, file type " . $sFileType ." is not prohibited.";
    }
    elseif ($intInspectResult == 2)
    {
        //echo "對不起，您的檔案上傳失敗，因為上傳的容量超出被允許的範圍";
        echo "Ops, your file size exceeded the prohibited range.";
    }
    elseif ($intInspectResult == 0)
    {
        echo "Inspecting " . $_FILES['myfile']['name'] . "  . . . .";
        //切割文字內容 只要遇到.就切成一個array
        $arrSm =  preg_split("/[.]+/", $_FILES['myfile']['name']);
        //抓取最後一個陣列
        $strEt = $arrSm[count($arrSm) - 1];
        //判斷是否符合以上FILE_TYPES中declarey過既名稱
        $k = 0;
        $q = 0;
        //修改檔名讓他不要重複
        //var_dump(basename('test.php', '.php')); 呢句都work
        $withoutExt = preg_replace("/\\.[^.\\s]{3,4}$/", "", $_FILES['myfile']['name']);
        $file_NAME = $Move . $withoutExt . "." . $strEt ; 
        while ($k == 0) {
            if (is_file($file_NAME)){
                $file_NAME = $Move . $withoutExt ."(" . $q . ")." . $strEt ;
                $q++ ;
                //存在
            }
            else {
                //不存在
                $k = 1;
            }
        }
        
        if (!(move_uploaded_file($_FILES['myfile']['tmp_name'], $file_NAME))) //failed
            {
                echo "檔案移動失敗，請重新上傳";
            }
            else  //success
            {
                //如果要結合資料庫的功能, 將寫入資料庫既code放係呢個block度
                    $sFileName = $_FILES['myfile']['name'];
                    $sFileType = $_FILES['myfile']['type'];
                    $sFileSize = bytesToSize1024($_FILES['myfile']['size'], 1);
                echo<<<EOF
                <div class="s">
                File upload successfully!<br/>
                File Name : {$sFileName}<br/>
                File Type : {$sFileType}<br/>
                File Size : {$sFileSize}YTES
                </div>
EOF;
            }
    }
