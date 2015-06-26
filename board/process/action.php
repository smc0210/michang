<? /// lastlog 2011-06-02 오후 6:17
    // working - 2010-06-02 : head code 추가 작업       -> 이걸 업데이트 하면 db 필드를 수정해야 한다.
    // working - 2010-08-30 [변경] : 워터마크 부분 작업
    // working - 2010-08-31 [오류] : 썸네일 width 값이 하나일때 오류 생김
    // working - 2010-09-02 [변경] : 썸네일 퀄리티 100으로 수정하기
    // working - 2010-09-02 [변경] : 워터마크 중앙에 뿌려주기
    // working - 2010-09-03 [개선] : 게시물 업데이트 부분 수정하기  
    // working - 2010-09-03 [추가] : 에디터 사용여부 추가
    // working - 2010-09-06 [변경] : 에디터에 삽입된 이미지에 워터마크 달기
    // working - 2010-09-08 [변경] : 워터마크 함수 추가
    // working - 2010-09-16 [추가] : list 페이지에서 수정 기능 추가 작업 listpage_field_modify
    // working - 2010-09-25 [변경] : 디자인 적용 작업
    // working - 2010-09-25 [추가] : 공지 기능 추가
	// working - 2010-09-28 [추가] : 계층형 게시판 작업 추가
    // working - 2010-10-01 [개선] : 링크 기능 추가 작업
    // working - 2010-12-24 [오류] : phone 정보가 저장이 안되는 오류 수정 작업
    // working - 2011-02-09 [추가] : 카테고리 메뉴 노출 부분 작업
    // working - 2011-02-09 [추가] : category_display_yn 기능 추가 작업
    // working - 2011-02-10 [추가] : 카테고리도 같이 삭제한다.
    require_once("../../config/init_sql.php");
    /////////////////////////////////////////////////////////////////////////////////
    // #variable 
    $debugLocal = "N";
    
    require_once($baseDir."libraries/file.php");
    /////////////////////////////////////////////////////////////////////////////////
    // #request POST
    // - actionType : insert, update
    if( $debugLocal == "Y" || false)
    {
        echo "request POST<br />";
        echo "<pre>";
        echo print_r($_POST);
        echo "</pre>";
        echo "request FILE<br />";
        echo "<pre>";
        echo print_r($_FILES);
        echo "</pre>";
        exit;
    }
    
    $titleDisplay = "게시판";
    /////////////////////////////////////////////////////////////////////////////////
    // #process 1. 컨트롤 로드
    if(!isset($common_control))
    {
        require_once($baseDir."model/common_control.php");
        $common_control = Common_control::singleton();
        if( $debugLocal == "Y" | false)
    	{
    		$common_control->debugModeOn();		
    	}                
    }
    
    if(!isset($board_control))
    {
    	require_once($baseDir."board/board_control.php");
    	$board_control = new Board_control();                
    	if( $debugLocal == "Y" || false)
    	{
    		$board_control->debugModeOn();		
    	}
    }
    
    if($title_en)
    {
        $boardTypeDatas = $board_control->getTypeDatasByTitleEn($title_en);
        $field_typeResult = $common_control->getType("field_type");
    }
    
    if( $debugLocal == "Y" || false)
    {
        echo "boardTypeDatas<br />";
        echo "<pre>";
        echo print_r($boardTypeDatas);
        echo "</pre>";
    }
    
    if($actionType == "update")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #variable 
        // tag_yn
        // option_yn
        // option_name
        // watermark_yn
        // watermark_img
        // editor_yn
        // etc_num
        // $category_display_yn 부분
        // $main_resize_type
        $updateResult = $board_control->updateData($number, $title, $title_en, $skin, $width, $code, $title_size, $link_yn, $uploadfile_num, $icon_display_time
                                                , $notice_yn, $secret_yn, $comment_yn, $next_prev_yn, $view_list_yn, $write_point, $comment_point
                                                , $thumbnail_yn, $thumbnail_width, $main_thumbnail_yn, $main_thumbnail_width, $category_yn, $category_type
                                                , $list_count, $head_code, $category_select_display_yn, $display_yn, $old_uploadfile_num
                                                , $tag_yn , $option_yn, $option_name, $watermark_yn, $watermark_img, $editor_yn, $etc_num, $template, $main_resize_type
                                                );
        if( !$updateResult )
        {
            alert($titleDisplay." 정보를 수정하는데 실패했습니다.");
        }
        else
        {
            alert($titleDisplay." 정보를 수정하였습니다.");
        }
        
        $directUrl = $baseUrl."gadmin/index.php?menu=board&submenu=board_list";   
    }
    else if($actionType == "insert")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - title              : 필수 
        // - code               
        // - title_en           : 필수 
        // - skin               : 필수
        // - width              : 필수 
        // - title_size
        // - link_yn
        // - uploadfile_num
        // - icon_display_time
        // - notice_yn
        // - secret_yn
        // - comment_yn
        // - next_prev_yn
        // - view_list_yn
        // - write_point
        // - comment_point
        // - thumbnail_yn
        // - thumbnail_width
        // - main_thumbnail_yn
        // - main_thumbnail_width
        // - category_yn
        // - category_type
        // - list_count
        // - head_code
        // - category_select_display_yn
        // - display_yn
        // - , $tag_yn , $option_yn, $option_name
        // - $watermark_yn
        // - $watermark_img
        // - editor_yn
        // - etc_num
        // - main_resize_type
        $insertId = $board_control->insertData($title, $title_en, $skin, $width, $code, $title_size, $link_yn, $uploadfile_num, $icon_display_time
                                                , $notice_yn, $secret_yn, $comment_yn, $next_prev_yn, $view_list_yn, $write_point, $comment_point
                                                , $thumbnail_yn, $thumbnail_width, $main_thumbnail_yn, $main_thumbnail_width, $category_yn, $category_type
                                                , $list_count, $head_code, $category_select_display_yn, $display_yn
                                                , $tag_yn , $option_yn, $option_name, $watermark_yn, $watermark_img,$editor_yn, $etc_num, $template, $main_resize_type
                                                );
        if( !$insertId )
        {
            alert($titleDisplay." 정보를 등록하지못했습니다.");
        }
        else
        {
            alert($titleDisplay." 정보를 등록하였습니다.");
        }
        
        if($template == "exam")
        {
            if(!isset($exam_control))
            {
                require_once($baseDir."exam/exam_control.php");
                $exam_control = new Exam_control();
                if( $debugLocal == "Y" || false)
            	{
            		$exam_control->debugModeOn();		
            	}                
            }
            $exam_control->insertExamExtension($insertId, $title);                        
        }
        
        $directUrl = $baseUrl."gadmin/index.php?menu=board&submenu=board_list";   
    }
    else if($actionType == "delete")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - idx
         
        /////////////////////////////////////////////////////////////////////////////////
        // #process 게시판 삭제하기
        $boardManagerData = $board_control->getBoardManagerData($idx);
        
        if($boardManagerData['template'] == 'exam')
        {
            if(!isset($exam_control))
            {
                require_once($baseDir."exam/exam_control.php");
                $exam_control = new Exam_control();
                if( $debugLocal == "Y" || false)
            	{
            		$exam_control->debugModeOn();		
            	}                
            }
            $exam_control->deleteExamExtensionByBoardManagerIdx($idx);
        }
        
        $isSuccess = $board_control->delete($idx);
       
        if(!isset($category_control))
        {
            require_once($baseDir."category/category_control.php");
            $category_control = new Category_control();
            if( $debugLocal == "Y" | false)
        	{
        		$category_control->debugModeOn();		
        	}                
        }
        
        $category_control->deleteDataExist($idx, "", "board");
       if($isSuccess)
       {
            alert("게시판 정보를 삭제하였습니다.");
       }
       else
       {
            alert("게시판 정보를 삭제하지못했습니다.");
       }                
                                                  
        $directUrl = $baseUrl."gadmin/index.php?menu=board&submenu=board_list";               
    }
    else if($actionType == "board_write")
    {
       /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - number
       // - code
       // - searchType
       // - search
       // - page
       // - title
       // - moduleName
       // - idx       
       // - tx_contents       
       // - tags
       // - file_name_1
       // - file_name_2
       // - file_name_3
       // - title_explain
       // - notice
       // - phone
       // - ss_idx sha1 id 값
       
       if($ss_idx == "")
       {
           if($_SESSION["ss_captcha"] != $captcha)
           {
                alert("인증번호 입력에 실패하였습니다.", "back");
                $isCheckOK = false;
                exit;     
           }        
       }                     
       /////////////////////////////////////////////////////////////////////////////////
       // #process 세팅 정보 가져오기
       $boardSetting = $board_control->getDataByCode($code);
       
       /////////////////////////////////////////////////////////////////////////////////
       // #process etc 처리 작업
       $etcArray = array();
       
        foreach($_POST as $key => $value)
        {        	
            if($key == "etc1")
            {
                $etcArray[$key] = $_POST['etc1'].":".$_POST['etc1_explain'];
            }
            if($key == "etc2")
            {
                $etcArray[$key] = $_POST['etc2'].":".$_POST['etc2_explain'];
            }
            if($key == "etc3")
            {
                $etcArray[$key] = $_POST['etc3'].":".$_POST['etc3_explain'];
            }
            if($key == "etc4")
            {
                $etcArray[$key] = $_POST['etc4'].":".$_POST['etc4_explain'];
            }
            if($key == "etc5")
            {
                $etcArray[$key] = $_POST['etc5'].":".$_POST['etc5_explain'];
            }
            if($key == "etc6")
            {
                $etcArray[$key] = $_POST['etc6'].":".$_POST['etc6_explain'];
            }
            if($key == "etc7")
            {
                $etcArray[$key] = $_POST['etc7'].":".$_POST['etc7_explain'];
            }
        }
        
        /////////////////////////////////////////////////////////////////////////////////
        // #process 메인 이미지 네임 쓰기
       $main_image_name = $_FILES['main_image_name'];
       $file_name_1 = $_FILES['file_name_1'];
       $file_name_2 = $_FILES['file_name_2'];
       $file_name_3 = $_FILES['file_name_3'];       
       
       $daumEditorDir = $baseDir."upload/";
            
       $main_image_name['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_1['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_2['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_3['new_name'] = date("YmdHis").makeRandomString(4);       
       $main_thumb_image_name = date("YmdHis").makeRandomString(4);
       
       $thumb_image_name = date("YmdHis").makeRandomString(4);
       $thumb_image2_name = date("YmdHis").makeRandomString(4);
       
       $file_name_1['name'] = str_replace(" ", "_", $file_name_1['name']);
       $file_name_2['name'] = str_replace(" ", "_", $file_name_2['name']);
       $file_name_3['name'] = str_replace(" ", "_", $file_name_3['name']);
       $title_explain = $title_explain."#!!#".$title_explain2;
        
        $dataArray = array();
        $fileArray = array();                   
        if(sizeof($boardTypeDatas) > 0)
        {
            reset($boardTypeDatas);
            foreach($boardTypeDatas as $idx => $boardData)
            {
                $board_title_en = $boardData['title_en'];
                $board_title_ko = $boardData['title_ko'];
                $board_field_type_name = $boardData['field_type_name'];
                
                if( $debugLocal == "Y" || false)
                {
                    echo "board_title_en : [".$board_title_en."]<br />";
                    echo "board_title_ko : [".$board_title_ko."]<br />";
                    echo "board_field_type_name : [".$board_field_type_name."]<br />";
                }
                
                if($board_field_type_name == "telephone")
                {
                    $telephone1 = $_POST[$board_title_en.'1'];
                    $telephone2 = $_POST[$board_title_en.'2'];
                    $telephone3 = $_POST[$board_title_en.'3'];
                    $dataArray[$board_title_en] = $telephone1."-".$telephone2."-".$telephone3; 
                }
                else if($board_field_type_name == "celphone")
                {
                    $celphone1 = $_POST[$board_title_en.'1'];
                    $celphone2 = $_POST[$board_title_en.'2'];
                    $celphone3 = $_POST[$board_title_en.'3'];
                    $dataArray[$board_title_en] = $celphone1."-".$celphone2."-".$celphone3; 
                }
                else if($board_field_type_name == "email")
                {
                    $dataArray[$board_title_en.'_id'] = $_POST[$board_title_en.'_id'];
                    $dataArray[$board_title_en.'_host'] = $_POST[$board_title_en.'_host'];
                    $dataArray[$board_title_en.'_type'] = $_POST[$board_title_en.'_type'];                      
                }
                else if($board_field_type_name == "checkbox")
                {
                    if(is_array($_POST[$board_title_en]))
                    {
                        $checkboxArray = $_POST[$board_title_en];
                        $checkboxString = implode(",", $checkboxArray);    
                    }
                    else
                    {
                        $checkboxString = $_POST[$board_title_en];
                    }
                    $dataArray[$board_title_en] = $checkboxString;
                }
                else if($board_field_type_name == "ssn")
                {
                    $dataArray[$board_title_en.'_1'] = $_POST[$board_title_en.'_1'];
                    $dataArray[$board_title_en.'_2'] = $_POST[$board_title_en.'_2'];                      
                }
                else if($board_field_type_name == "date_term")
                {
                    $dataArray[$board_title_en.'_start'] = $_POST[$board_title_en.'_start'];
                    $dataArray[$board_title_en.'_end'] = $_POST[$board_title_en.'_end'];
                }
                else if($board_field_type_name == "date_y")
                {
                    $dataArray[$board_title_en] = $_POST[$board_title_en.'_year'];
                }
                else if($board_field_type_name == "date_ym")
                {
                    $year = $_POST[$board_title_en.'_year'];
                    $month = $_POST[$board_title_en.'_month'];
                    
                    $dataArray[$board_title_en] = $year."-".fillZero($month, 2);
                }
                // $board_field_type_name == "date_y" || $board_field_type_name == "date_ym" ||
                else if($board_field_type_name == "company")
                {
                    $company = $_POST[$board_title_en.'1'];
                    $company_detail = $_POST[$board_title_en.'_detail'];
                    
                    $dataArray[$board_title_en] = $company."#!!#".$company_detail;
                }
                else if($board_field_type_name == "address_sidogu")
                {
                    $address_sido = $_POST[$board_title_en];
                    $address_detail = $_POST[$board_title_en.'_detail'];
                    
                    $dataArray[$board_title_en] = $address_sido."#!!#".$address_detail;
                }
                else if($board_field_type_name == "address_sidogueup")
                {
                    $address_sido = $_POST[$board_title_en];
                    $address_detail = $_POST[$board_title_en.'_detail'];
                    $address_detail2 = $_POST[$board_title_en.'_detail2'];
                    
                    $dataArray[$board_title_en] = $address_sido."#!!#".$address_detail."#!!#".$address_detail2;
                }  
                else if($board_field_type_name == "file")
                {
                    $fileArray[$board_title_en]['new_name'] = date("YmdHis").makeRandomString(4);
                    $fileDatas = $_FILES[$board_title_en];
                    
                    $fileArray[$board_title_en]['size'] = $fileDatas["size"];
                    $fileArray[$board_title_en]['name'] = $fileDatas["name"];
                    $fileArray[$board_title_en]['type'] = $fileDatas["type"];
                    $fileArray[$board_title_en]['tmp_name'] = $fileDatas["tmp_name"];
                }
                else if($board_field_type_name == "text" || $board_field_type_name == "textarea" || $board_field_type_name == "select" || $board_field_type_name == "radio" || $board_field_type_name == "integer"  || $board_field_type_name == "date_ymd" || $board_field_type_name == "address_sido")
                {
                    $dataArray[$board_title_en] = $_POST[$board_title_en];
                }
            }    
        }
        
        if($_SESSION['ss_user_idx'] == "" && $ss_idx != "")
        {   // 세션이 날라갔을 때
            alert("글작성에 실패하였습니다. 3");
        }
        else
        {
            /////////////////////////////////////////////////////////////////////////////////
            // #process 링크 정보가 틀리다면 없앤다.
            if(!isURL($link))
            {
                //$link = "";
            }
            
            $insertId = $board_control->writeData($title_en, $title, $tx_contents, $_SESSION['ss_user_idx'], $main_image_name
                                                    , $user_name
                                                    , $email
                                                    , $thumb_image_name
                                                    , $etcArray
                                                    , $password
                                                    , $category_type
                                                    , $display_order
                                                    , $dataArray
                                                    , $fileArray
                                                    , $thumb_image2_name
                                                    , $main_thumb_image_name
                                                    , $file_name_1
                                                    , $file_name_2
                                                    , $file_name_3
                                                    , $title_explain
                                                    , $notice
                                                    , $secret_yn
                                                    , $link
                                                    , $phone
                                                );
           
           $add_data_arr = array();
           if($boardSetting['template'] == 'tour')
           {
                $add_data_arr['price'] = $price;
                $add_data_arr['price2'] = $price2;
                $add_data_arr['price3'] = $price3;
                $add_data_arr['nights'] = $nights;
                $add_data_arr['days'] = $days;
                $add_data_arr['depart_date'] = $depart_date;
                $add_data_arr['land_date'] = $land_date;
                $add_data_arr['cities'] = $cities;
                $add_data_arr['incl'] = $incl;
                $add_data_arr['not_incl'] = $not_incl;
                $add_data_arr['charge'] = $charge;
                $add_data_arr['bookinfo'] = $bookinfo;
                $add_data_arr['meeting'] = $meeting;
                $add_data_arr['fuelcharge'] = $fuelcharge;
                $add_data_arr['airport'] = $airport;
                $add_data_arr['insurance'] = $insurance;
                $add_data_arr['passportvisa'] = $passportvisa;
                
                $file_path = $baseDir."board/boardSkin/s_nowcroatia/";
                $schedule = '<TABLE cellSpacing=0 cellPadding=0 width=780 border=0>';
                $schedule .= '<TBODY><TR><TD><IMG ';
                $schedule .= 'src="/board/boardSkin/s_nowcroatia/images/view/head_sch.gif"';
                $schedule .= 'width=780 height=31></TD></TR></TBODY></TABLE>';
                
                for($i=1; $i<=$days; $i++)
                        $schedule .= getHtmlData($file_path."schedule.htm");
                
                $check_point = getHtmlData($file_path."check_point.htm");
                
                $add_data_arr['schedule'] = $schedule;
                $add_data_arr['check_point'] = $check_point;
                
                $board_control->update_add_data($insertId, $add_data_arr, $title_en);
           }
           elseif($boardSetting['template'] == 'event')
           {
                $add_data_arr['start_date'] = $start_date;
                $add_data_arr['end_date'] = $end_date;
                
                $board_control->update_add_data($insertId, $add_data_arr, $title_en);
           }
           elseif($boardSetting['template'] == 'calendar')
           {
                $add_data_arr['start_date'] = $start_date;
                $add_data_arr['end_date'] = $end_date;
                $add_data_arr['comment'] = $comment;
                
                $board_control->update_add_data($insertId, $add_data_arr, $title_en);
           }
           elseif($boardSetting['template'] == 'branch')
           {
                $add_data_arr['address'] = $address;
                $add_data_arr['fax'] = $fax;
                
                $board_control->update_add_data($insertId, $add_data_arr, $title_en);
           }
           
           $main_image_name['name'] = str_replace(" ", "_", $main_image_name['name']);
            
            $moduleName = "board_".$title_en;       
            /////////////////////////////////////////////////////////////////////////////////
            // #process 이미지 썸네일 정보 가져오기
            $boardData = $board_control->getDataByBoardName($title_en);
            
            if(isset($main_image_name) && $main_image_name['size'] != '0')
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$main_image_name['tmp_name'],$main_image_name['new_name']);
                
                if($boardData['main_thumbnail_yn'] == "Y")
                {
                    $main_thumbnail_width = $boardData['main_thumbnail_width'];
                    
                    $thumbnail_widthArray = explode("*", $main_thumbnail_width);
                    
                    $width = 0;
                    $height = 0;
                    if(sizeof($thumbnail_widthArray) == 1)
                    {
                        $width = $thumbnail_widthArray[0];  
                        $height = 0;
                    }
                    else
                    {
                        $width = $thumbnail_widthArray[0];
                        $height = $thumbnail_widthArray[1];
                    }
                    
                    if( $debugLocal == "Y" || false)
                    {
                        echo "main_thumbnail_width width : [".$width."]<br />";
                        echo "main_thumbnail_width height : [".$height."]<br />";
                    }
                    if($boardData['watermark_yn'] == "Y")
                    {
                        $options = Array();//옵션설정
                        
                        if($boardData['main_resize_type'] == "crop")
                        {
                            $options['crop_use'] = 1;
                            $options['crop_pos_width'] = 2;
                            $options['crop_pos_height '] = 3;
                            // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                            // $options['watermark_sharpness'] = 100;
                            // $options['watermark_pos'] = 4;
                            saveThumbCropFile($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);                            
                        }
                        else if($boardData['main_resize_type'] == "resize")
                        {
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        else    
                        {   // fix 인 경우와 설정이 안되어 있는 경우
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                    }
                    else
                    {
                        $options = Array();//옵션설정
                        
                        if($boardData['main_resize_type'] == "crop")
                        {
                            $options['crop_use'] = 1;
                            $options['crop_pos_width'] = 2;
                            $options['crop_pos_height '] = 3;    
                            $options['save_quality'] = 100;
                            
                            saveThumbCropFile($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type']);                
                        }
                        else if($boardData['main_resize_type'] == "resize")
                        {
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        else    
                        {   // fix 인 경우와 설정이 안되어 있는 경우
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        
                        
                    }
                }
                
                if($boardData['thumbnail_yn'] == "Y")
                {
                    $thumbnail_widthArray = explode(",", $boardData['thumbnail_width']);
                    
                    for($i=0; $i < sizeof($thumbnail_widthArray); $i++)
                    {
                        $thumbnail_width2Array = explode("*", $thumbnail_widthArray[$i]);
                        $width = 0;
                        $height = 0;
                        if(sizeof($thumbnail_width2Array) == 1)
                        {
                            $width = $thumbnail_width2Array[0];  
                            $height = 0;
                        }
                        else
                        {
                            $width = $thumbnail_width2Array[0];
                            $height = $thumbnail_width2Array[1];
                        }
                        if( $debugLocal == "Y" || false)
                        {
                            echo "sizeof(thumbnail_widthArray) == 2 width : [".$width."]<br />";
                            echo "sizeof(thumbnail_widthArray) == 2 height : [".$height."]<br />";
                        }
                        
                        $thumb_str = 'thumb_image'.($i+1).'_name';
                        if($thumb_str == 'thumb_image1_name')
                            $thumb_str = 'thumb_image_name';
                        
                        if($boardData['watermark_yn'] == "Y")
                        {
                            $options = Array();//옵션설정
                            
                            // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                            // $options['watermark_sharpness'] = 100;
                            // $options['watermark_pos'] = 4;
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $$thumb_str, $width, $height, $main_image_name['type'], $options);
                        }
                        else
                        {
                            $options = Array();//옵션설정
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName, $insertId, $main_image_name['new_name'], $$thumb_str, $width, $height, $main_image_name['type']);
                        }
                    }
                }                
            }
            
            if(isset($file_name_1))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_1['tmp_name'],$file_name_1['new_name']);
            }
            if(isset($file_name_2))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_2['tmp_name'],$file_name_2['new_name']);    
            }
            if(isset($file_name_3))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_3['tmp_name'],$file_name_3['new_name']);    
            }
            
            if(sizeof($fileArray))
            {
                reset($fileArray);
                foreach($fileArray as $board_title_en => $fileData)
                {
                    saveAttFile($daumEditorDir, $moduleName,$insertId,$fileData['tmp_name'],$fileData['new_name']);
                }
            }
            
            if( !$insertId )
            {
                alert("글작성 실패했습니다. 1");
            }
            else
            {
                $imageUrl = $_POST['tx_attach_imageurl'];
                $filename = $_POST['tx_attach_filename'];
                $fileSize = $_POST['tx_attach_filesize'];
                
                for($i=0; $i < sizeof($imageUrl); $i++)
                {
                    $board_control->insertEditorFile($title_en, $insertId, $imageUrl[$i], $filename[$i], $fileSize[$i], $boardData['content_watermark_yn']);
                    if($boardData['content_watermark_yn'] == "Y")
                    {
                        // imageUrl : http://g-maker.com/upload/board_board1/24/20100903144227260
                        // filename : _MOO8875.JPG
                        // module_name : board_board1
                        $options = Array();//옵션설정
                        $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                        watermarkFile($imageUrl[$i], $options);
                    }
                }
            }
            
            /////////////////////////////////////////////////////////////////////////////////
            // #process tags 처리 부분이 필요하다.
            if($tags != "")
            {
                $isSuccess = $board_control->insertTags($title_en, $insertId, $tags);    
            }
            
            /////////////////////////////////////////////////////////////////////////////////
            // #process 옵션 부분 처리 내용이 필요하다.
           	$selectNumArray = $_POST['selectNum'];
            $usageArray = $_POST['usage'];
            $formatArray = $_POST['format'];
            $toolsArray = $_POST['tools'];
            $resolutionArray = $_POST['resolution'];
            $sizeArray = $_POST['size'];
            $priceArray = $_POST['price'];
            $sale_priceArray = $_POST['sale_price'];
            $pointArray = $_POST['point'];
            
            for($i=0; $i < sizeof($selectNumArray); $i++)
            {
                $selectNum = intval($selectNumArray[$i]);
                
                $option_file_name = $_FILES['option_file_name_'.$selectNum];
                
                $optionFileArray['new_name'] = date("YmdHis").makeRandomString(4);                                        
                $optionFileArray['size'] = $option_file_name["size"];
                $optionFileArray['name'] = $option_file_name["name"];
                $optionFileArray['type'] = $option_file_name["type"];
                $optionFileArray['tmp_name'] = $option_file_name["tmp_name"];
                
                if($selectNum < 10000)
                {            
                    $board_control->updateOptionData($title_en, $insertId, $selectNum, $usageArray[$i], $formatArray[$i], $toolsArray[$i], $resolutionArray[$i], $sizeArray[$i], $priceArray[$i], $sale_priceArray[$i], $pointArray[$i], $optionFileArray);        
                }
                else
                {
                    $board_control->insertOptionData($title_en, $insertId, $usageArray[$i], $formatArray[$i], $toolsArray[$i], $resolutionArray[$i], $sizeArray[$i], $priceArray[$i], $sale_priceArray[$i], $pointArray[$i], $optionFileArray);   
                }
                
                saveAttFile($daumEditorDir, $moduleName,$insertId, $optionFileArray['tmp_name'], $optionFileArray['new_name']);                    
            }
            /////////////////////////////////////////////////////////////////////////////////
            // #process 질문/답변 게시판의 경우에는 메일링을 해야 한다.
            if($title_en == "qna")  
            {   /// \todo 이 부분에서 qna 부분 처리가 필요할 것 같다.
                if(!isset($mail_control))
                {
                    require_once($baseDir."mail/mail_control.php");
                    $mail_control = new Mail_control();
                    if( $debugLocal == "Y" | false)
                	{
                		$mail_control->debugModeOn();		
                	}                
                }
                $mailContents = $board_control->getMailContents($title_en, $insertId);
                
                if( $debugLocal == "Y" || false)
                {
                    echo "title_en : [".$title_en."]<br />";
                    echo "insertId : [".$insertId."]<br />";
                    echo "mailContents : [".$mailContents."]<br />";
                }
                if(!isset($common_control))
                {
                    require_once($baseDir."model/common_control.php");
                    $common_control = Common_control::singleton();
                    if( $debugLocal == "Y" | false)
                	{
                		$common_control->debugModeOn();		
                	}                
                }
                $siteResult = $common_control->getSiteType();
                $receiveEmail = $siteResult['email'];            
                if( $mail_control->receiveMail($receiveEmail, $email, "", "질문-답변에서 문의가 들어왔습니다.", $mailContents) )
                {
                    //alert("글작성에 성공하였습니다.");
                }
                else
                {
                    //alert("글작성에 실패하였습니다. 2");
                }
            }
            else
            {
                //alert("글작성에 성공하였습니다.");
            }                        
        }
        
        $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&category=".$category_type."&mode=list";          
        
    }
    
    else if($actionType == "osome_write")
    {
            if($_POST['file1'] == 'Y')
            {
                $file_array['file1'] = 'file1';
                $code_array['file1'] = 'PT5EBY54';
            }
            if($_POST['file2'] == 'Y')
            {
                $file_array['file2'] = 'file2';
                $code_array['file2'] = 'JY47dHG2';
            }
            if($_POST['file3'] == 'Y')
            {
                $file_array['file3'] = 'file3';
                $code_array['file3'] = 'xVx9SdJx';
            }
                
        foreach($file_array AS $file_idx => $file_value)
        {
                $tmp = $title_en;
                $title_en = $file_value;
                
       if($ss_idx == "")
       {
           if($_SESSION["ss_captcha"] != $captcha)
           {
                alert("인증번호 입력에 실패하였습니다.", "back");
                $isCheckOK = false;
                exit;     
           }        
       }                     
       
       
       if(!isset($category2_control))
        {
            $boardSetting = $board_control->getDataByCode($code);
            
            require_once($baseDir."category/category2_control.php");
            $category2_control = new Category2_control();
            
            $category2_control->init_code("board", $boardSetting['idx']);
            $categoryTreeDatas = $category2_control->getDepthMenu($category);
            
            foreach($categoryTreeDatas as $cidx => $cvalue)
            {
                if($cvalue['idx'] == $category_type)
                    $category_order = $cvalue['order']; 
            }
            
            $tmp2 = $code;
            $code = $code_array[$file_idx];
            
            $boardSetting = $board_control->getDataByCode($code);
            
            $category2_control->init_code("board", $boardSetting['idx']);
            $categoryTreeDatas = $category2_control->getDepthMenu($category);
            
            foreach($categoryTreeDatas as $cidx => $cvalue)
            {
                if($cvalue['order'] == $category_order)
                    $category_type  = $cvalue['idx'];
            } 
        }
        else
        {
            $tmp2 = $code;
            $code = $code_array[$file_idx];
            
            $boardSetting = $board_control->getDataByCode($code);
            
            $category2_control->init_code("board", $boardSetting['idx']);
            $categoryTreeDatas = $category2_control->getDepthMenu($category);
            
            foreach($categoryTreeDatas as $cidx => $cvalue)
            {
                if($cvalue['order'] == $category_order)
                    $category_type  = $cvalue['idx'];
            } 
        }
       
       /////////////////////////////////////////////////////////////////////////////////
       // #process etc 처리 작업
       $etcArray = array();
       
        foreach($_POST as $key => $value)
        {        	
            if($key == "etc1")
            {
                $etcArray[$key] = $_POST['etc1'].":".$_POST['etc1_explain'];
            }
            if($key == "etc2")
            {
                $etcArray[$key] = $_POST['etc2'].":".$_POST['etc2_explain'];
            }
            if($key == "etc3")
            {
                $etcArray[$key] = $_POST['etc3'].":".$_POST['etc3_explain'];
            }
            if($key == "etc4")
            {
                $etcArray[$key] = $_POST['etc4'].":".$_POST['etc4_explain'];
            }
            if($key == "etc5")
            {
                $etcArray[$key] = $_POST['etc5'].":".$_POST['etc5_explain'];
            }
            if($key == "etc6")
            {
                $etcArray[$key] = $_POST['etc6'].":".$_POST['etc6_explain'];
            }
            if($key == "etc7")
            {
                $etcArray[$key] = $_POST['etc7'].":".$_POST['etc7_explain'];
            }
        }
        
        /////////////////////////////////////////////////////////////////////////////////
        // #process 메인 이미지 네임 쓰기
       $main_image_name = $_FILES['main_image_name'];
       $file_name_1 = $_FILES['file_name_1'];
       $file_name_2 = $_FILES['file_name_2'];
       $file_name_3 = $_FILES['file_name_3'];       
       
       $daumEditorDir = $baseDir."upload/";
            
       $main_image_name['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_1['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_2['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_3['new_name'] = date("YmdHis").makeRandomString(4);       
       $main_thumb_image_name = date("YmdHis").makeRandomString(4);
       $thumb_image_name = date("YmdHis").makeRandomString(4);
       $thumb_image2_name = date("YmdHis").makeRandomString(4);
       $file_name_1['name'] = str_replace(" ", "_", $file_name_1['name']);
       $file_name_2['name'] = str_replace(" ", "_", $file_name_2['name']);
       $file_name_3['name'] = str_replace(" ", "_", $file_name_3['name']);
       $title_explain = $title_explain."#!!#".$title_explain2;
        
        $dataArray = array();
        $fileArray = array();                   
        if(sizeof($boardTypeDatas) > 0)
        {
            reset($boardTypeDatas);
            foreach($boardTypeDatas as $idx => $boardData)
            {
                $board_title_en = $boardData['title_en'];
                $board_title_ko = $boardData['title_ko'];
                $board_field_type_name = $boardData['field_type_name'];
                
                if( $debugLocal == "Y" || false)
                {
                    echo "board_title_en : [".$board_title_en."]<br />";
                    echo "board_title_ko : [".$board_title_ko."]<br />";
                    echo "board_field_type_name : [".$board_field_type_name."]<br />";
                }
                
                if($board_field_type_name == "telephone")
                {
                    $telephone1 = $_POST[$board_title_en.'1'];
                    $telephone2 = $_POST[$board_title_en.'2'];
                    $telephone3 = $_POST[$board_title_en.'3'];
                    $dataArray[$board_title_en] = $telephone1."-".$telephone2."-".$telephone3; 
                }
                else if($board_field_type_name == "celphone")
                {
                    $celphone1 = $_POST[$board_title_en.'1'];
                    $celphone2 = $_POST[$board_title_en.'2'];
                    $celphone3 = $_POST[$board_title_en.'3'];
                    $dataArray[$board_title_en] = $celphone1."-".$celphone2."-".$celphone3; 
                }
                else if($board_field_type_name == "email")
                {
                    $dataArray[$board_title_en.'_id'] = $_POST[$board_title_en.'_id'];
                    $dataArray[$board_title_en.'_host'] = $_POST[$board_title_en.'_host'];
                    $dataArray[$board_title_en.'_type'] = $_POST[$board_title_en.'_type'];                      
                }
                else if($board_field_type_name == "checkbox")
                {
                    if(is_array($_POST[$board_title_en]))
                    {
                        $checkboxArray = $_POST[$board_title_en];
                        $checkboxString = implode(",", $checkboxArray);    
                    }
                    else
                    {
                        $checkboxString = $_POST[$board_title_en];
                    }
                    $dataArray[$board_title_en] = $checkboxString;
                }
                else if($board_field_type_name == "ssn")
                {
                    $dataArray[$board_title_en.'_1'] = $_POST[$board_title_en.'_1'];
                    $dataArray[$board_title_en.'_2'] = $_POST[$board_title_en.'_2'];                      
                }
                else if($board_field_type_name == "date_term")
                {
                    $dataArray[$board_title_en.'_start'] = $_POST[$board_title_en.'_start'];
                    $dataArray[$board_title_en.'_end'] = $_POST[$board_title_en.'_end'];
                }
                else if($board_field_type_name == "date_y")
                {
                    $dataArray[$board_title_en] = $_POST[$board_title_en.'_year'];
                }
                else if($board_field_type_name == "date_ym")
                {
                    $year = $_POST[$board_title_en.'_year'];
                    $month = $_POST[$board_title_en.'_month'];
                    
                    $dataArray[$board_title_en] = $year."-".fillZero($month, 2);
                }
                // $board_field_type_name == "date_y" || $board_field_type_name == "date_ym" ||
                else if($board_field_type_name == "company")
                {
                    $company = $_POST[$board_title_en.'1'];
                    $company_detail = $_POST[$board_title_en.'_detail'];
                    
                    $dataArray[$board_title_en] = $company."#!!#".$company_detail;
                }
                else if($board_field_type_name == "address_sidogu")
                {
                    $address_sido = $_POST[$board_title_en];
                    $address_detail = $_POST[$board_title_en.'_detail'];
                    
                    $dataArray[$board_title_en] = $address_sido."#!!#".$address_detail;
                }
                else if($board_field_type_name == "address_sidogueup")
                {
                    $address_sido = $_POST[$board_title_en];
                    $address_detail = $_POST[$board_title_en.'_detail'];
                    $address_detail2 = $_POST[$board_title_en.'_detail2'];
                    
                    $dataArray[$board_title_en] = $address_sido."#!!#".$address_detail."#!!#".$address_detail2;
                }  
                else if($board_field_type_name == "file")
                {
                    $fileArray[$board_title_en]['new_name'] = date("YmdHis").makeRandomString(4);
                    $fileDatas = $_FILES[$board_title_en];
                    
                    $fileArray[$board_title_en]['size'] = $fileDatas["size"];
                    $fileArray[$board_title_en]['name'] = $fileDatas["name"];
                    $fileArray[$board_title_en]['type'] = $fileDatas["type"];
                    $fileArray[$board_title_en]['tmp_name'] = $fileDatas["tmp_name"];
                }
                else if($board_field_type_name == "text" || $board_field_type_name == "textarea" || $board_field_type_name == "select" || $board_field_type_name == "radio" || $board_field_type_name == "integer"  || $board_field_type_name == "date_ymd" || $board_field_type_name == "address_sido")
                {
                    $dataArray[$board_title_en] = $_POST[$board_title_en];
                }
            }    
        }
        
        if($_SESSION['ss_user_idx'] == "" && $ss_idx != "")
        {   // 세션이 날라갔을 때
            alert("글작성에 실패하였습니다. 3");
        }
        else
        {
            /////////////////////////////////////////////////////////////////////////////////
            // #process 링크 정보가 틀리다면 없앤다.
            if(!isURL($link))
            {
                $link = "";
            }
            
            if($title_en == "book1" || $title_en == "book2") {
           $insertId = $board_control->writecishopData($title_en, $title, $tx_contents, $_SESSION['ss_user_idx'], $main_image_name
                                                    , $user_name
                                                    , $email
                                                    , $thumb_image_name
                                                    , $etcArray
                                                    , $password
                                                    , $category_type
                                                    , $display_order
                                                    , $dataArray
                                                    , $fileArray
                                                    , $thumb_image2_name
                                                    , $main_thumb_image_name
                                                    , $file_name_1
                                                    , $file_name_2
                                                    , $file_name_3
                                                    , $title_explain
                                                    , $notice
                                                    , $secret_yn
                                                    , $link
                                                    , $phone
                                                    , $price
                                                    , $sell_price
                                                    , $company
                                                    , $discount_yn
                                                ); }
           else
           {
            $insertId = $board_control->writeData($title_en, $title, $tx_contents, $_SESSION['ss_user_idx'], $main_image_name
                                                    , $user_name
                                                    , $email
                                                    , $thumb_image_name
                                                    , $etcArray
                                                    , $password
                                                    , $category_type
                                                    , $display_order
                                                    , $dataArray
                                                    , $fileArray
                                                    , $thumb_image2_name
                                                    , $main_thumb_image_name
                                                    , $file_name_1
                                                    , $file_name_2
                                                    , $file_name_3
                                                    , $title_explain
                                                    , $notice
                                                    , $secret_yn
                                                    , $link
                                                    , $phone
                                                );
           }
           $main_image_name['name'] = str_replace(" ", "_", $main_image_name['name']);
            
            $moduleName = "board_".$title_en;       
            /////////////////////////////////////////////////////////////////////////////////
            // #process 이미지 썸네일 정보 가져오기
            $boardData = $board_control->getDataByBoardName($title_en);
            
            if(isset($main_image_name))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$main_image_name['tmp_name'],$main_image_name['new_name']);
                
                if($boardData['main_thumbnail_yn'] == "Y")
                {
                    $main_thumbnail_width = $boardData['main_thumbnail_width'];
                    
                    $thumbnail_widthArray = explode("*", $main_thumbnail_width);
                    
                    $width = 0;
                    $height = 0;
                    if(sizeof($thumbnail_widthArray) == 1)
                    {
                        $width = $thumbnail_widthArray[0];  
                        $height = 0;
                    }
                    else
                    {
                        $width = $thumbnail_widthArray[0];
                        $height = $thumbnail_widthArray[1];
                    }
                    
                    if( $debugLocal == "Y" || false)
                    {
                        echo "main_thumbnail_width width : [".$width."]<br />";
                        echo "main_thumbnail_width height : [".$height."]<br />";
                    }
                    if($boardData['watermark_yn'] == "Y")
                    {
                        $options = Array();//옵션설정
                        
                        if($boardData['main_resize_type'] == "crop")
                        {
                            $options['crop_use'] = 1;
                            $options['crop_pos_width'] = 2;
                            $options['crop_pos_height '] = 3;
                            // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                            // $options['watermark_sharpness'] = 100;
                            // $options['watermark_pos'] = 4;
                            saveThumbCropFile($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);                            
                        }
                        else if($boardData['main_resize_type'] == "resize")
                        {
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        else    
                        {   // fix 인 경우와 설정이 안되어 있는 경우
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                    }
                    else
                    {
                        $options = Array();//옵션설정
                        
                        if($boardData['main_resize_type'] == "crop")
                        {
                            $options['crop_use'] = 1;
                            $options['crop_pos_width'] = 2;
                            $options['crop_pos_height '] = 3;    
                            $options['save_quality'] = 100;
                            
                            saveThumbCropFile($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type']);                
                        }
                        else if($boardData['main_resize_type'] == "resize")
                        {
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        else    
                        {   // fix 인 경우와 설정이 안되어 있는 경우
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        
                        
                    }
                }
                
                if($boardData['thumbnail_yn'] == "Y")
                {
                    $thumbnail_widthArray = explode(",", $boardData['thumbnail_width']);
                    
                    if(sizeof($thumbnail_widthArray) == 1)
                    {
                        $thumbnail_widthArray2 = explode("*", $thumbnail_widthArray[0]);
                        $width = 0;
                        $height = 0;
                        if(sizeof($thumbnail_widthArray2) == 1)
                        {
                            $width = $thumbnail_widthArray2[0];  
                            $height = 0;
                        }
                        else
                        {
                            $width = $thumbnail_widthArray2[0];
                            $height = $thumbnail_widthArray2[1];
                        }
                        
                        if( $debugLocal == "Y" || false)
                        {
                            echo "thumbnail_width width : [".$width."]<br />";
                            echo "thumbnail_width height : [".$height."]<br />";
                        }
                        if($boardData['watermark_yn'] == "Y")
                        {
                            $options = Array();//옵션설정
        
                            // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                            // $options['watermark_sharpness'] = 100;
                            // $options['watermark_pos'] = 4;
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        else
                        {
                            $options = Array();//옵션설정
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $thumb_image_name, $width, $height, $main_image_name['type']);    
                        }
                            
                    }
                    else if(sizeof($thumbnail_widthArray) == 2)
                    {
                        for($i=0; $i < sizeof($thumbnail_widthArray); $i++)
                        {
                            $thumbnail_width2Array = explode("*", $thumbnail_widthArray[$i]);
                            $width = 0;
                            $height = 0;
                            if(sizeof($thumbnail_width2Array) == 1)
                            {
                                $width = $thumbnail_width2Array[0];  
                                $height = 0;
                            }
                            else
                            {
                                $width = $thumbnail_width2Array[0];
                                $height = $thumbnail_width2Array[1];
                            }
                            if( $debugLocal == "Y" || false)
                            {
                                echo "sizeof(thumbnail_widthArray) == 2 width : [".$width."]<br />";
                                echo "sizeof(thumbnail_widthArray) == 2 height : [".$height."]<br />";
                            }
                            
                            if($i == 0)
                            {
                                if($boardData['watermark_yn'] == "Y")
                                {
                                    $options = Array();//옵션설정
                                                
                                    // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                                    // $options['watermark_sharpness'] = 100;
                                    // $options['watermark_pos'] = 4;
                                    $options['ratio'] = 1;
                                    $options['save_quality'] = 100;
                                    saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $thumb_image_name, $width, $height, $main_image_name['type'], $options);
                                }
                                else
                                {
                                    $options = Array();//옵션설정
                                    $options['save_quality'] = 100;
                                    saveThumbFile2($daumEditorDir, $moduleName, $insertId, $main_image_name['new_name'], $thumb_image_name, $width, $height, $main_image_name['type']);
                                }     
                            }
                            else
                            {
                                if($boardData['watermark_yn'] == "Y")
                                {
                                    $options = Array();//옵션설정
                
                                    $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                                    $options['watermark_sharpness'] = 100;
                                    $options['watermark_pos'] = 5;
                                    $options['ratio'] = 1;
                                    $options['save_quality'] = 100;
                                    saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $thumb_image2_name, $width, $height, $main_image_name['type'], $options);
                                }
                                else
                                {
                                    $options = Array();//옵션설정
                                    $options['save_quality'] = 100;
                                    saveThumbFile2($daumEditorDir, $moduleName, $insertId, $main_image_name['new_name'], $thumb_image2_name, $width, $height, $main_image_name['type']);
                                }
                            }
                                
                        }
                    }
                }                
            }
            
            if(isset($file_name_1))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_1['tmp_name'],$file_name_1['new_name']);
            }
            if(isset($file_name_2))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_2['tmp_name'],$file_name_2['new_name']);    
                
            }
            if(isset($file_name_3))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_3['tmp_name'],$file_name_3['new_name']);    
            }
            
            if(sizeof($fileArray))
            {
                reset($fileArray);
                
                foreach($fileArray as $board_title_en => $fileData)
                {
                    $result = saveAttFile($daumEditorDir, $moduleName,$insertId,$fileData['tmp_name'],$fileData['new_name']);
                    $tmp_name = $fileData['tmp_name'];
                        if($result==false && $tmp_name)
                        {
                
                $destin_dir  = $daumEditorDir . $moduleName . "/" . $insertId;
                $destin_file = $destin_dir . "/" . $fileData['new_name'];
                copy($target_file[$board_title_en],$destin_file);
                
                        }
                        elseif($result==true)
                        {
                
                $target_dir  = $daumEditorDir . $moduleName . "/" . $insertId;
    $target_file[$board_title_en] = $target_dir . "/" . $fileData['new_name'];
                
                        }
                }
            }
            
            if( !$insertId )
            {
                alert("글작성 실패했습니다. 1");
            }
            else
            {
                $imageUrl = $_POST['tx_attach_imageurl'];
                $filename = $_POST['tx_attach_filename'];
                $fileSize = $_POST['tx_attach_filesize'];
                
                for($i=0; $i < sizeof($imageUrl); $i++)
                {
                    $board_control->insertEditorFile($title_en, $insertId, $imageUrl[$i], $filename[$i], $fileSize[$i], $boardData['content_watermark_yn']);
                    if($boardData['content_watermark_yn'] == "Y")
                    {
                        // imageUrl : http://g-maker.com/upload/board_board1/24/20100903144227260
                        // filename : _MOO8875.JPG
                        // module_name : board_board1
                        $options = Array();//옵션설정
                        $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                        watermarkFile($imageUrl[$i], $options);
                    }
                }
            }
            
            /////////////////////////////////////////////////////////////////////////////////
            // #process tags 처리 부분이 필요하다.
            if($tags != "")
            {
                $isSuccess = $board_control->insertTags($title_en, $insertId, $tags);    
            }
            
            /////////////////////////////////////////////////////////////////////////////////
            // #process 옵션 부분 처리 내용이 필요하다.
           	$selectNumArray = $_POST['selectNum'];
            $usageArray = $_POST['usage'];
            $formatArray = $_POST['format'];
            $toolsArray = $_POST['tools'];
            $resolutionArray = $_POST['resolution'];
            $sizeArray = $_POST['size'];
            $priceArray = $_POST['price'];
            $sale_priceArray = $_POST['sale_price'];
            $pointArray = $_POST['point'];
            
            for($i=0; $i < sizeof($selectNumArray); $i++)
            {
                $selectNum = intval($selectNumArray[$i]);
                
                $option_file_name = $_FILES['option_file_name_'.$selectNum];
                
                $optionFileArray['new_name'] = date("YmdHis").makeRandomString(4);                                        
                $optionFileArray['size'] = $option_file_name["size"];
                $optionFileArray['name'] = $option_file_name["name"];
                $optionFileArray['type'] = $option_file_name["type"];
                $optionFileArray['tmp_name'] = $option_file_name["tmp_name"];
                
                if($selectNum < 10000)
                {            
                    $board_control->updateOptionData($title_en, $insertId, $selectNum, $usageArray[$i], $formatArray[$i], $toolsArray[$i], $resolutionArray[$i], $sizeArray[$i], $priceArray[$i], $sale_priceArray[$i], $pointArray[$i], $optionFileArray);        
                }
                else
                {
                    $board_control->insertOptionData($title_en, $insertId, $usageArray[$i], $formatArray[$i], $toolsArray[$i], $resolutionArray[$i], $sizeArray[$i], $priceArray[$i], $sale_priceArray[$i], $pointArray[$i], $optionFileArray);   
                }
                
                saveAttFile($daumEditorDir, $moduleName,$insertId, $optionFileArray['tmp_name'], $optionFileArray['new_name']);                    
            }
            /////////////////////////////////////////////////////////////////////////////////
            // #process 질문/답변 게시판의 경우에는 메일링을 해야 한다.
            if($title_en == "qna")  
            {   /// \todo 이 부분에서 qna 부분 처리가 필요할 것 같다.
                if(!isset($mail_control))
                {
                    require_once($baseDir."mail/mail_control.php");
                    $mail_control = new Mail_control();
                    if( $debugLocal == "Y" | false)
                	{
                		$mail_control->debugModeOn();		
                	}                
                }
                $mailContents = $board_control->getMailContents($title_en, $insertId);
                
                if( $debugLocal == "Y" || false)
                {
                    echo "title_en : [".$title_en."]<br />";
                    echo "insertId : [".$insertId."]<br />";
                    echo "mailContents : [".$mailContents."]<br />";
                }
                if(!isset($common_control))
                {
                    require_once($baseDir."model/common_control.php");
                    $common_control = Common_control::singleton();
                    if( $debugLocal == "Y" | false)
                	{
                		$common_control->debugModeOn();		
                	}                
                }
                $siteResult = $common_control->getSiteType();
                $receiveEmail = $siteResult['email'];            
                if( $mail_control->receiveMail($receiveEmail, $email, "", "질문-답변에서 문의가 들어왔습니다.", $mailContents) )
                {
                    //alert("글작성에 성공하였습니다.");
                }
                else
                {
                    //alert("글작성에 실패하였습니다. 2");
                }
            }
            else
            {
                //alert("글작성에 성공하였습니다.");
            }                        
        }
        
        
        $title_en = $tmp;
        $code = $tmp2;
        }
        
        $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&category=".$category."&mode=list";          
        
    }
    
    else if($actionType == "board_write_test")
    {
       /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - number
       // - code
       // - searchType
       // - search
       // - page
       // - title
       // - moduleName
       // - idx       
       // - tx_contents       
       // - tags
       // - file_name_1
       // - file_name_2
       // - file_name_3
       // - title_explain
       // - notice
       // - phone
       // - ss_idx sha1 id 값     
       /////////////////////////////////////////////////////////////////////////////////
       // #process 세팅 정보 가져오기
       $boardSetting = $board_control->getDataByCode($code);
       
       /////////////////////////////////////////////////////////////////////////////////
       // #process etc 처리 작업
       $etcArray = array();
       
        foreach($_POST as $key => $value)
        {        	
            if($key == "etc1")
            {
                $etcArray[$key] = $_POST['etc1'].":".$_POST['etc1_explain'];
            }
            if($key == "etc2")
            {
                $etcArray[$key] = $_POST['etc2'].":".$_POST['etc2_explain'];
            }
            if($key == "etc3")
            {
                $etcArray[$key] = $_POST['etc3'].":".$_POST['etc3_explain'];
            }
            if($key == "etc4")
            {
                $etcArray[$key] = $_POST['etc4'].":".$_POST['etc4_explain'];
            }
            if($key == "etc5")
            {
                $etcArray[$key] = $_POST['etc5'].":".$_POST['etc5_explain'];
            }
            if($key == "etc6")
            {
                $etcArray[$key] = $_POST['etc6'].":".$_POST['etc6_explain'];
            }
            if($key == "etc7")
            {
                $etcArray[$key] = $_POST['etc7'].":".$_POST['etc7_explain'];
            }
        }
        
        /////////////////////////////////////////////////////////////////////////////////
        // #process 메인 이미지 네임 쓰기
       $main_image_name = $_FILES['main_image_name'];
       $file_name_1 = $_FILES['file_name_1'];
       $file_name_2 = $_FILES['file_name_2'];
       $file_name_3 = $_FILES['file_name_3'];       
       
       $daumEditorDir = $baseDir."upload/";
            
       $main_image_name['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_1['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_2['new_name'] = date("YmdHis").makeRandomString(4);
       $file_name_3['new_name'] = date("YmdHis").makeRandomString(4);       
       $main_thumb_image_name = date("YmdHis").makeRandomString(4);
       $thumb_image_name = date("YmdHis").makeRandomString(4);
       $thumb_image2_name = date("YmdHis").makeRandomString(4);
       $file_name_1['name'] = str_replace(" ", "_", $file_name_1['name']);
       $file_name_2['name'] = str_replace(" ", "_", $file_name_2['name']);
       $file_name_3['name'] = str_replace(" ", "_", $file_name_3['name']);
       $title_explain = $title_explain."#!!#".$title_explain2;
        
        $dataArray = array();
        $fileArray = array();                   
        if(sizeof($boardTypeDatas) > 0)
        {
            reset($boardTypeDatas);
            foreach($boardTypeDatas as $idx => $boardData)
            {
                $board_title_en = $boardData['title_en'];
                $board_title_ko = $boardData['title_ko'];
                $board_field_type_name = $boardData['field_type_name'];
                
                if( $debugLocal == "Y" || false)
                {
                    echo "board_title_en : [".$board_title_en."]<br />";
                    echo "board_title_ko : [".$board_title_ko."]<br />";
                    echo "board_field_type_name : [".$board_field_type_name."]<br />";
                }
                
                if($board_field_type_name == "telephone")
                {
                    $telephone1 = $_POST[$board_title_en.'1'];
                    $telephone2 = $_POST[$board_title_en.'2'];
                    $telephone3 = $_POST[$board_title_en.'3'];
                    $dataArray[$board_title_en] = $telephone1."-".$telephone2."-".$telephone3; 
                }
                else if($board_field_type_name == "celphone")
                {
                    $celphone1 = $_POST[$board_title_en.'1'];
                    $celphone2 = $_POST[$board_title_en.'2'];
                    $celphone3 = $_POST[$board_title_en.'3'];
                    $dataArray[$board_title_en] = $celphone1."-".$celphone2."-".$celphone3; 
                }
                else if($board_field_type_name == "email")
                {
                    $dataArray[$board_title_en.'_id'] = $_POST[$board_title_en.'_id'];
                    $dataArray[$board_title_en.'_host'] = $_POST[$board_title_en.'_host'];
                    $dataArray[$board_title_en.'_type'] = $_POST[$board_title_en.'_type'];                      
                }
                else if($board_field_type_name == "checkbox")
                {
                    if(is_array($_POST[$board_title_en]))
                    {
                        $checkboxArray = $_POST[$board_title_en];
                        $checkboxString = implode(",", $checkboxArray);    
                    }
                    else
                    {
                        $checkboxString = $_POST[$board_title_en];
                    }
                    $dataArray[$board_title_en] = $checkboxString;
                }
                else if($board_field_type_name == "ssn")
                {
                    $dataArray[$board_title_en.'_1'] = $_POST[$board_title_en.'_1'];
                    $dataArray[$board_title_en.'_2'] = $_POST[$board_title_en.'_2'];                      
                }
                else if($board_field_type_name == "date_term")
                {
                    $dataArray[$board_title_en.'_start'] = $_POST[$board_title_en.'_start'];
                    $dataArray[$board_title_en.'_end'] = $_POST[$board_title_en.'_end'];
                }
                else if($board_field_type_name == "date_y")
                {
                    $dataArray[$board_title_en] = $_POST[$board_title_en.'_year'];
                }
                else if($board_field_type_name == "date_ym")
                {
                    $year = $_POST[$board_title_en.'_year'];
                    $month = $_POST[$board_title_en.'_month'];
                    
                    $dataArray[$board_title_en] = $year."-".fillZero($month, 2);
                }
                // $board_field_type_name == "date_y" || $board_field_type_name == "date_ym" ||
                else if($board_field_type_name == "company")
                {
                    $company = $_POST[$board_title_en.'1'];
                    $company_detail = $_POST[$board_title_en.'_detail'];
                    
                    $dataArray[$board_title_en] = $company."#!!#".$company_detail;
                }
                else if($board_field_type_name == "address_sidogu")
                {
                    $address_sido = $_POST[$board_title_en];
                    $address_detail = $_POST[$board_title_en.'_detail'];
                    
                    $dataArray[$board_title_en] = $address_sido."#!!#".$address_detail;
                }
                else if($board_field_type_name == "address_sidogueup")
                {
                    $address_sido = $_POST[$board_title_en];
                    $address_detail = $_POST[$board_title_en.'_detail'];
                    $address_detail2 = $_POST[$board_title_en.'_detail2'];
                    
                    $dataArray[$board_title_en] = $address_sido."#!!#".$address_detail."#!!#".$address_detail2;
                }  
                else if($board_field_type_name == "file")
                {
                    $fileArray[$board_title_en]['new_name'] = date("YmdHis").makeRandomString(4);
                    $fileDatas = $_FILES[$board_title_en];
                    
                    $fileArray[$board_title_en]['size'] = $fileDatas["size"];
                    $fileArray[$board_title_en]['name'] = $fileDatas["name"];
                    $fileArray[$board_title_en]['type'] = $fileDatas["type"];
                    $fileArray[$board_title_en]['tmp_name'] = $fileDatas["tmp_name"];
                }
                else if($board_field_type_name == "text" || $board_field_type_name == "textarea" || $board_field_type_name == "select" || $board_field_type_name == "radio" || $board_field_type_name == "integer"  || $board_field_type_name == "date_ymd" || $board_field_type_name == "address_sido")
                {
                    $dataArray[$board_title_en] = $_POST[$board_title_en];
                }
            }    
        }
        
        
            /////////////////////////////////////////////////////////////////////////////////
            // #process 링크 정보가 틀리다면 없앤다.
            if(!isURL($link))
            {
                $link = "";
            }
                        
           $insertId = $board_control->writeData($title_en, $title, $tx_contents, $_SESSION['ss_user_idx'], $main_image_name
                                                    , $user_name
                                                    , $email
                                                    , $thumb_image_name
                                                    , $etcArray
                                                    , $password
                                                    , $category_type
                                                    , $display_order
                                                    , $dataArray
                                                    , $fileArray
                                                    , $thumb_image2_name
                                                    , $main_thumb_image_name
                                                    , $file_name_1
                                                    , $file_name_2
                                                    , $file_name_3
                                                    , $title_explain
                                                    , $notice
                                                    , $secret_yn
                                                    , $link
                                                    , $phone
                                                );
                            
           $main_image_name['name'] = str_replace(" ", "_", $main_image_name['name']);
            
            $moduleName = "board_".$title_en;       
            /////////////////////////////////////////////////////////////////////////////////
            // #process 이미지 썸네일 정보 가져오기
            $boardData = $board_control->getDataByBoardName($title_en);
            
            if(isset($main_image_name))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$main_image_name['tmp_name'],$main_image_name['new_name']);
                
                if($boardData['main_thumbnail_yn'] == "Y")
                {
                    $main_thumbnail_width = $boardData['main_thumbnail_width'];
                    
                    $thumbnail_widthArray = explode("*", $main_thumbnail_width);
                    
                    $width = 0;
                    $height = 0;
                    if(sizeof($thumbnail_widthArray) == 1)
                    {
                        $width = $thumbnail_widthArray[0];  
                        $height = 0;
                    }
                    else
                    {
                        $width = $thumbnail_widthArray[0];
                        $height = $thumbnail_widthArray[1];
                    }
                    
                    if( $debugLocal == "Y" || false)
                    {
                        echo "main_thumbnail_width width : [".$width."]<br />";
                        echo "main_thumbnail_width height : [".$height."]<br />";
                    }
                    if($boardData['watermark_yn'] == "Y")
                    {
                        $options = Array();//옵션설정
                        
                        $options['crop_use'] = 1;
                        $options['crop_pos_width'] = 2;
                        $options['crop_pos_height '] = 3;
                        // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                        // $options['watermark_sharpness'] = 100;
                        // $options['watermark_pos'] = 4;
                        $options['ratio'] = 1;
                        $options['save_quality'] = 100;
                        saveThumbCropFile($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                    }
                    else
                    {
                        $options = Array();//옵션설정
                        
                        $options['crop_use'] = 1;
                        $options['crop_pos_width'] = 2;
                        $options['crop_pos_height '] = 3;    
                        $options['save_quality'] = 100;                
                        saveThumbCropFile($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type']);
                    }
                }
                
                if($boardData['thumbnail_yn'] == "Y")
                {
                    $thumbnail_widthArray = explode(",", $boardData['thumbnail_width']);
                    
                    if(sizeof($thumbnail_widthArray) == 1)
                    {
                        $thumbnail_widthArray2 = explode("*", $thumbnail_widthArray[0]);
                        $width = 0;
                        $height = 0;
                        if(sizeof($thumbnail_widthArray2) == 1)
                        {
                            $width = $thumbnail_widthArray2[0];  
                            $height = 0;
                        }
                        else
                        {
                            $width = $thumbnail_widthArray2[0];
                            $height = $thumbnail_widthArray2[1];
                        }
                        
                        if( $debugLocal == "Y" || false)
                        {
                            echo "thumbnail_width width : [".$width."]<br />";
                            echo "thumbnail_width height : [".$height."]<br />";
                        }
                        if($boardData['watermark_yn'] == "Y")
                        {
                            $options = Array();//옵션설정
        
                            // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                            // $options['watermark_sharpness'] = 100;
                            // $options['watermark_pos'] = 4;
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        else
                        {
                            $options = Array();//옵션설정
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $thumb_image_name, $width, $height, $main_image_name['type']);    
                        }
                            
                    }
                    else if(sizeof($thumbnail_widthArray) == 2)
                    {
                        for($i=0; $i < sizeof($thumbnail_widthArray); $i++)
                        {
                            $thumbnail_width2Array = explode("*", $thumbnail_widthArray[$i]);
                            $width = 0;
                            $height = 0;
                            if(sizeof($thumbnail_width2Array) == 1)
                            {
                                $width = $thumbnail_width2Array[0];  
                                $height = 0;
                            }
                            else
                            {
                                $width = $thumbnail_width2Array[0];
                                $height = $thumbnail_width2Array[1];
                            }
                            if( $debugLocal == "Y" || false)
                            {
                                echo "sizeof(thumbnail_widthArray) == 2 width : [".$width."]<br />";
                                echo "sizeof(thumbnail_widthArray) == 2 height : [".$height."]<br />";
                            }
                            
                            if($i == 0)
                            {
                                if($boardData['watermark_yn'] == "Y")
                                {
                                    $options = Array();//옵션설정
                                                
                                    // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                                    // $options['watermark_sharpness'] = 100;
                                    // $options['watermark_pos'] = 4;
                                    $options['ratio'] = 1;
                                    $options['save_quality'] = 100;
                                    saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $thumb_image_name, $width, $height, $main_image_name['type'], $options);
                                }
                                else
                                {
                                    $options = Array();//옵션설정
                                    $options['save_quality'] = 100;
                                    saveThumbFile2($daumEditorDir, $moduleName, $insertId, $main_image_name['new_name'], $thumb_image_name, $width, $height, $main_image_name['type']);
                                }     
                            }
                            else
                            {
                                if($boardData['watermark_yn'] == "Y")
                                {
                                    $options = Array();//옵션설정
                
                                    $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                                    $options['watermark_sharpness'] = 100;
                                    $options['watermark_pos'] = 5;
                                    $options['ratio'] = 1;
                                    $options['save_quality'] = 100;
                                    saveThumbFile2($daumEditorDir, $moduleName,$insertId,$main_image_name['new_name'], $thumb_image2_name, $width, $height, $main_image_name['type'], $options);
                                }
                                else
                                {
                                    $options = Array();//옵션설정
                                    $options['save_quality'] = 100;
                                    saveThumbFile2($daumEditorDir, $moduleName, $insertId, $main_image_name['new_name'], $thumb_image2_name, $width, $height, $main_image_name['type']);
                                }
                            }
                                
                        }
                    }
                }                
            }
            
            if(isset($file_name_1))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_1['tmp_name'],$file_name_1['new_name']);
            }
            if(isset($file_name_2))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_2['tmp_name'],$file_name_2['new_name']);    
            }
            if(isset($file_name_3))
            {
                saveAttFile($daumEditorDir, $moduleName,$insertId,$file_name_3['tmp_name'],$file_name_3['new_name']);    
            }
            
            if(sizeof($fileArray))
            {
                reset($fileArray);
                foreach($fileArray as $board_title_en => $fileData)
                {
                    saveAttFile($daumEditorDir, $moduleName,$insertId,$fileData['tmp_name'],$fileData['new_name']);
                }
            }
            
            if( !$insertId )
            {
                alert("글작성 실패했습니다. 1");
            }
            else
            {
                $imageUrl = $_POST['tx_attach_imageurl'];
                $filename = $_POST['tx_attach_filename'];
                $fileSize = $_POST['tx_attach_filesize'];
                
                for($i=0; $i < sizeof($imageUrl); $i++)
                {
                    $board_control->insertEditorFile($title_en, $insertId, $imageUrl[$i], $filename[$i], $fileSize[$i], $boardData['content_watermark_yn']);
                    if($boardData['content_watermark_yn'] == "Y")
                    {
                        // imageUrl : http://g-maker.com/upload/board_board1/24/20100903144227260
                        // filename : _MOO8875.JPG
                        // module_name : board_board1
                        $options = Array();//옵션설정
                        $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                        watermarkFile($imageUrl[$i], $options);
                    }
                }
            }
            
            /////////////////////////////////////////////////////////////////////////////////
            // #process tags 처리 부분이 필요하다.
            if($tags != "")
            {
                $isSuccess = $board_control->insertTags($title_en, $insertId, $tags);    
            }
            
            /////////////////////////////////////////////////////////////////////////////////
            // #process 옵션 부분 처리 내용이 필요하다.
           	$selectNumArray = $_POST['selectNum'];
            $usageArray = $_POST['usage'];
            $formatArray = $_POST['format'];
            $toolsArray = $_POST['tools'];
            $resolutionArray = $_POST['resolution'];
            $sizeArray = $_POST['size'];
            $priceArray = $_POST['price'];
            $sale_priceArray = $_POST['sale_price'];
            $pointArray = $_POST['point'];
            
            for($i=0; $i < sizeof($selectNumArray); $i++)
            {
                $selectNum = intval($selectNumArray[$i]);
                
                $option_file_name = $_FILES['option_file_name_'.$selectNum];
                
                $optionFileArray['new_name'] = date("YmdHis").makeRandomString(4);                                        
                $optionFileArray['size'] = $option_file_name["size"];
                $optionFileArray['name'] = $option_file_name["name"];
                $optionFileArray['type'] = $option_file_name["type"];
                $optionFileArray['tmp_name'] = $option_file_name["tmp_name"];
                
                if($selectNum < 10000)
                {            
                    $board_control->updateOptionData($title_en, $insertId, $selectNum, $usageArray[$i], $formatArray[$i], $toolsArray[$i], $resolutionArray[$i], $sizeArray[$i], $priceArray[$i], $sale_priceArray[$i], $pointArray[$i], $optionFileArray);        
                }
                else
                {
                    $board_control->insertOptionData($title_en, $insertId, $usageArray[$i], $formatArray[$i], $toolsArray[$i], $resolutionArray[$i], $sizeArray[$i], $priceArray[$i], $sale_priceArray[$i], $pointArray[$i], $optionFileArray);   
                }
                
                saveAttFile($daumEditorDir, $moduleName,$insertId, $optionFileArray['tmp_name'], $optionFileArray['new_name']);                    
            }
            /////////////////////////////////////////////////////////////////////////////////
            // #process 질문/답변 게시판의 경우에는 메일링을 해야 한다.
            if($title_en == "qna")  
            {   /// \todo 이 부분에서 qna 부분 처리가 필요할 것 같다.
                if(!isset($mail_control))
                {
                    require_once($baseDir."mail/mail_control.php");
                    $mail_control = new Mail_control();
                    if( $debugLocal == "Y" | false)
                	{
                		$mail_control->debugModeOn();		
                	}                
                }
                $mailContents = $board_control->getMailContents($title_en, $insertId);
                
                if( $debugLocal == "Y" || false)
                {
                    echo "title_en : [".$title_en."]<br />";
                    echo "insertId : [".$insertId."]<br />";
                    echo "mailContents : [".$mailContents."]<br />";
                }
                if(!isset($common_control))
                {
                    require_once($baseDir."model/common_control.php");
                    $common_control = Common_control::singleton();
                    if( $debugLocal == "Y" | false)
                	{
                		$common_control->debugModeOn();		
                	}                
                }
                $siteResult = $common_control->getSiteType();
                $receiveEmail = $siteResult['email'];            
                if( $mail_control->receiveMail($receiveEmail, $email, "", "질문-답변에서 문의가 들어왔습니다.", $mailContents) )
                {
                    //alert("글작성에 성공하였습니다.");
                }
                else
                {
                    //alert("글작성에 실패하였습니다. 2");
                }
            }
            else
            {
                // alert("글작성에 성공하였습니다.");
            }                        
                 
        $common_model->updateCommonData($old_table, array("insert_yn" => "Y"), array("b_idx" => $b_idx) );                                                       
        $directUrl = $baseUrl."board_write_guest.php";          
        
    }
    else if($actionType == "board_modify")
    {
       /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
       // - main_image_name     : FILE
       // - file_name_1         : FILE
       // - file_name_2         : FILE
       // - file_name_3         : FILE
       // - display_order
       // - phone
         
       $etcArray = array();
       
       foreach($_POST as $key => $value){        	
            if($key == "etc1")
            {
                $etcArray[$key] = $_POST['etc1'].":".$_POST['etc1_explain'];
            }
            if($key == "etc2")
            {
                $etcArray[$key] = $_POST['etc2'].":".$_POST['etc2_explain'];
            }
            if($key == "etc3")
            {
                $etcArray[$key] = $_POST['etc3'].":".$_POST['etc3_explain'];
            }
            if($key == "etc4")
            {
                $etcArray[$key] = $_POST['etc4'].":".$_POST['etc4_explain'];
            }
            if($key == "etc5")
            {
                $etcArray[$key] = $_POST['etc5'].":".$_POST['etc5_explain'];
            }
            if($key == "etc6")
            {
                $etcArray[$key] = $_POST['etc6'].":".$_POST['etc6_explain'];
            }
            if($key == "etc7")
            {
                $etcArray[$key] = $_POST['etc7'].":".$_POST['etc7_explain'];
            }
        }
        
        $main_image_name = $_FILES['main_image_name'];
        $file_name_1 = $_FILES['file_name_1'];
        $file_name_2 = $_FILES['file_name_2'];
        $file_name_3 = $_FILES['file_name_3'];        

        $dataArray = array();
        $fileArray = array();
        
        if( $debugLocal == "Y" || false)
        {
            echo "boardTypeDatas<br />";
            echo "<pre>";
            echo print_r($boardTypeDatas);
            echo "</pre>";
        }                   
        
        if(sizeof($boardTypeDatas) > 0)
        {
            reset($boardTypeDatas);
            foreach($boardTypeDatas as $idx => $boardData)
            {
                $board_title_en = $boardData['title_en'];
                $board_title_ko = $boardData['title_ko'];
                $board_field_type_name = $boardData['field_type_name'];
        
                if( $debugLocal == "Y" || false)
                {
                    echo "board_title_en : [".$board_title_en."]<br />";
                    echo "board_title_ko : [".$board_title_ko."]<br />";
                    echo "board_field_type_name : [".$board_field_type_name."]<br />";
                }
        
                if($board_field_type_name == "telephone")
                {
                    $telephone1 = $_POST[$board_title_en.'1'];
                    $telephone2 = $_POST[$board_title_en.'2'];
                    $telephone3 = $_POST[$board_title_en.'3'];
                    $dataArray[$board_title_en] = $telephone1."-".$telephone2."-".$telephone3; 
                }
                else if($board_field_type_name == "celphone")
                {
                    $celphone1 = $_POST[$board_title_en.'1'];
                    $celphone2 = $_POST[$board_title_en.'2'];
                    $celphone3 = $_POST[$board_title_en.'3'];
                    $dataArray[$board_title_en] = $celphone1."-".$celphone2."-".$celphone3; 
                }
                else if($board_field_type_name == "email")
                {
                    $dataArray[$board_title_en.'_id'] = $_POST[$board_title_en.'_id'];
                    $dataArray[$board_title_en.'_host'] = $_POST[$board_title_en.'_host'];
                    $dataArray[$board_title_en.'_type'] = $_POST[$board_title_en.'_type'];                       
                }
                else if($board_field_type_name == "text" || $board_field_type_name == "textarea" || $board_field_type_name == "select" || $board_field_type_name == "radio" || $board_field_type_name == "date_ymd")
                {
                    $dataArray[$board_title_en] = $_POST[$board_title_en];
                }
                else if($board_field_type_name == "checkbox")
                {
                    if(is_array($_POST[$board_title_en]))
                    {
                        $checkboxArray = $_POST[$board_title_en];
                        $checkboxString = implode(",", $checkboxArray);
                    }
                    else
                    {
                        $checkboxString = $_POST[$board_title_en];
                    }
                                            
                    $dataArray[$board_title_en] = $checkboxString;
                }
                else if($board_field_type_name == "ssn")
                {
                    $dataArray[$board_title_en.'_1'] = $_POST[$board_title_en.'_1'];
                    $dataArray[$board_title_en.'_2'] = $_POST[$board_title_en.'_2'];                      
                }
                else if($board_field_type_name == "date_term")
                {
                    $dataArray[$board_title_en.'_start'] = $_POST[$board_title_en.'_start'];
                    $dataArray[$board_title_en.'_end'] = $_POST[$board_title_en.'_end'];
                }
                else if($board_field_type_name == "company")
                {
                    $company = $_POST[$board_title_en.'1'];
                    $company_detail = $_POST[$board_title_en.'_detail'];
                    
                    $dataArray[$board_title_en] = $company."#!!#".$company_detail;
                }
                else if($board_field_type_name == "address_sidogu")
                {
                    $address_sido = $_POST[$board_title_en];
                    $address_detail = $_POST[$board_title_en.'_detail'];
                    
                    $dataArray[$board_title_en] = $address_sido."#!!#".$address_detail;
                }                  
                else if($board_field_type_name == "address_sidogueup")
                {
                    $address_sido = $_POST[$board_title_en];
                    $address_detail = $_POST[$board_title_en.'_detail'];
                    $address_detail2 = $_POST[$board_title_en.'_detail2'];
                    
                    $dataArray[$board_title_en] = $address_sido."#!!#".$address_detail."#!!#".$address_detail;
                }
                else if($board_field_type_name == "file")
                {
                    $fileArray[$board_title_en]['new_name'] = date("YmdHis").makeRandomString(4);
                    $fileDatas = $_FILES[$board_title_en];
                    
                    $fileArray[$board_title_en]['size'] = $fileDatas["size"];
                    $fileArray[$board_title_en]['name'] = $fileDatas["name"];
                    $fileArray[$board_title_en]['type'] = $fileDatas["type"];
                    $fileArray[$board_title_en]['tmp_name'] = $fileDatas["tmp_name"];
                    
                    $real_name = $_POST["real_".$board_title_en];
                    if($fileDatas["name"] == "" && $real_name == "")
                    {
                        $fileArray[$board_title_en] = "delete";
                    }
                }
                else 
                {
                    $dataArray[$board_title_en] = $_POST[$board_title_en];
                }
            }    
        }
        
        if( $debugLocal == "Y" || false)
        {
            echo '$dataArray<br />';
            echo '<pre>';
            echo print_r($dataArray);
            echo '</pre>';
        }
        if( $debugLocal == "Y" || false)
        {
            echo "fileArray<br />";
            echo "<pre>";
            echo print_r($fileArray);
            echo "</pre>";
        }
        $moduleName = "board_".$title_en;
         
        if( $debugLocal == "Y" || false)
        {
            if($main_image_name != "")
            {
                echo "main_image_name is not blank<br />";
                echo "main_image_name<br />";
                echo "<pre>";
                echo print_r($main_image_name);
                echo "</pre>";    
            }
            else
            {
                echo "main_image_name is blank<br />";    
            }
        }                
        if($main_image_name != "")
        {
            if($main_image_name['name'] == "")
            {
                $main_image_name = "";
                $thumb_image_name = "";
                $main_thumb_image_name = "";
                $thumb_image2_name = "";
            }
            else
            {
                $main_image_name['new_name'] = date("YmdHis").makeRandomString(4);
                $thumb_image_name = date("YmdHis").makeRandomString(4);
                $main_thumb_image_name  = date("YmdHis").makeRandomString(4);
                $thumb_image2_name = date("YmdHis").makeRandomString(4);                   
            }
        }
        
        // $title_explain = $title_explain."#!!#".$title_explain2;
        
        if($file_name_1 != "")
        {
            if($file_name_1['name'] == "")
            {
                $file_name_1 = "";
                if($real_file_name_1 == "")
                {
                    $file_name_1 = "delete";
                }
            }
            else
            {
                $file_name_1['new_name'] = date("YmdHis").makeRandomString(4);    
            }            
            
        }
                      
        if($file_name_2 != "")
        {
            if($file_name_2['name'] == "")
            {
                $file_name_2 = "";
                if($real_file_name_2 == "")
                {
                    $file_name_2 = "delete";
                }                
            }
            else
            {
                $file_name_2['new_name'] = date("YmdHis").makeRandomString(4);    
            } 
        }
        
        if($file_name_3 != "")
        {
            if($file_name_3['name'] == "")
            {
                $file_name_3 = "";
                if($real_file_name_3 == "")
                {
                    $file_name_3 = "delete";
                }                
            }
            else
            {
                $file_name_3['new_name'] = date("YmdHis").makeRandomString(4);    
            } 
        }
        
        $title_explain = $title_explain."#!!#".$title_explain2;        
        if($oldPassword == $password)
        {
            $password = "";
        }
        
        if(!isURL($link))
        {
            //$link = "";
        }
        
        $isSuccess = $board_control->modifyData2($title_en, $number, $title, $tx_contents, $main_image_name
                                                                , $thumb_image_name, $etcArray, $password, $category_type
                                                                , $display_order
                                                                , $dataArray
                                                                , $fileArray
                                                                , $thumb_image2_name
                                                                , $main_thumb_image_name
                                                                , $file_name_1
                                                                , $file_name_2
                                                                , $file_name_3
                                                                , $title_explain
                                                                , $notice
                                                                , $secret_yn 
                                                                , $link
                                                                , $phone
                                                                , $email
                                                                , $user_name
                                                );
                                                
        $boardSetting = $board_control->getDataByCode($code);
        
        $add_data_arr = array();
        if($boardSetting['template'] == 'tour')
        {
                $add_data_arr['price'] = $price;
                $add_data_arr['price2'] = $price2;
                $add_data_arr['price3'] = $price3;
                $add_data_arr['nights'] = $nights;
                $add_data_arr['days'] = $days;
                $add_data_arr['depart_date'] = $depart_date;
                $add_data_arr['land_date'] = $land_date;
                $add_data_arr['cities'] = $cities;
                $add_data_arr['incl'] = $incl;
                $add_data_arr['not_incl'] = $not_incl;
                $add_data_arr['charge'] = $charge;
                $add_data_arr['bookinfo'] = $bookinfo;
                $add_data_arr['meeting'] = $meeting;
                $add_data_arr['fuelcharge'] = $fuelcharge;
                $add_data_arr['airport'] = $airport;
                $add_data_arr['insurance'] = $insurance;
                $add_data_arr['passportvisa'] = $passportvisa;
                
                $board_control->update_add_data($number, $add_data_arr, $title_en);
        }
        elseif($boardSetting['template'] == 'event')
        {
                $add_data_arr['start_date'] = $start_date;
                $add_data_arr['end_date'] = $end_date;
                
                $board_control->update_add_data($number, $add_data_arr, $title_en);
        }
        elseif($boardSetting['template'] == 'calendar')
        {
                $add_data_arr['start_date'] = $start_date;
                $add_data_arr['end_date'] = $end_date;
                $add_data_arr['comment'] = $comment;
                
                $board_control->update_add_data($number, $add_data_arr, $title_en);
        }
        elseif($boardSetting['template'] == 'branch')
        {
                $add_data_arr['address'] = $address;
                $add_data_arr['fax'] = $fax;
                
                $board_control->update_add_data($number, $add_data_arr, $title_en);
        }
        
        if( !$isSuccess )
        {
            alert("글수정에 실패했습니다.");
        }
        else
        {
            /////////////////////////////////////////////////////////////////////////////////
            // #process tags 처리 부분이 필요하다.
            $isSuccess = $board_control->updateTags($title_en, $number, $tags);    
                    
            $daumEditorDir = $baseDir."upload/";
            /////////////////////////////////////////////////////////////////////////////////
            // #process 이미지 썸네일 정보 가져오기
            $boardData = $board_control->getDataByBoardName($title_en);
            
            if($main_image_name != "" && $main_image_name['name'] != "")
            {
                saveAttFile($daumEditorDir, $moduleName,$number,$main_image_name['tmp_name'],$main_image_name['new_name']);   
                
                if($boardData['main_thumbnail_yn'] == "Y")
                {
                    $main_thumbnail_width = $boardData['main_thumbnail_width'];
                    
                    $thumbnail_widthArray = explode("*", $main_thumbnail_width);
                    
                    $width = 0;
                    $height = 0;
                    if(sizeof($thumbnail_widthArray) == 1)
                    {
                        $width = $thumbnail_widthArray[0];  
                        $height = 0;
                    }
                    else
                    {
                        $width = $thumbnail_widthArray[0];
                        $height = $thumbnail_widthArray[1];
                    }
                    
                    if( $debugLocal == "Y" || false)
                    {
                        echo "main_thumbnail_width width : [".$width."]<br />";
                        echo "main_thumbnail_width height : [".$height."]<br />";
                    }
                    if($boardData['watermark_yn'] == "Y")
                    {
                        $options = Array();//옵션설정
                        
                        if($boardData['main_resize_type'] == "crop")
                        {
                            $options['crop_use'] = 1;
                            $options['crop_pos_width'] = 2;
                            $options['crop_pos_height '] = 3;
                            $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                            $options['watermark_sharpness'] = 100;
                            $options['watermark_pos'] = 4;
                            
                            saveThumbCropFile($daumEditorDir, $moduleName,$number,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);                            
                        }
                        else if($boardData['main_resize_type'] == "resize")
                        {
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            $options['watermark_path_file'] = $boardData['watermark_img'];
                            $options['watermark_sharpness'] = 100;
                            $options['watermark_pos'] = 4;
                            
                            saveThumbFile2($daumEditorDir, $moduleName,$number,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        else    
                        {   // fix 인 경우와 설정이 안되어 있는 경우
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$number,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                    }
                    else
                    {
                        $options = Array();//옵션설정
                        
                        if($boardData['main_resize_type'] == "crop")
                        {
                            $options['crop_use'] = 1;
                            $options['crop_pos_width'] = 2;
                            $options['crop_pos_height '] = 3;    
                            $options['save_quality'] = 100;
                            
                            saveThumbCropFile($daumEditorDir, $moduleName,$number,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type']);                
                        }
                        else if($boardData['main_resize_type'] == "resize")
                        {
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$number,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                        else    
                        {   // fix 인 경우와 설정이 안되어 있는 경우
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$number,$main_image_name['new_name'], $main_thumb_image_name, $width, $height, $main_image_name['type'], $options);
                        }
                    }                    
                }
                
                if($boardData['thumbnail_yn'] == "Y")
                {
                    $thumbnail_widthArray = explode(",", $boardData['thumbnail_width']);
                    
                    for($i=0; $i < sizeof($thumbnail_widthArray); $i++)
                    {
                        $thumbnail_width2Array = explode("*", $thumbnail_widthArray[$i]);
                        $width = 0;
                        $height = 0;
                        if(sizeof($thumbnail_width2Array) == 1)
                        {
                            $width = $thumbnail_width2Array[0];  
                            $height = 0;
                        }
                        else
                        {
                            $width = $thumbnail_width2Array[0];
                            $height = $thumbnail_width2Array[1];
                        }
                        
                        $thumb_str = 'thumb_image'.($i+1).'_name';
                        if($thumb_str == 'thumb_image1_name')
                            $thumb_str = 'thumb_image_name';
                        
                        if($boardData['watermark_yn'] == "Y")
                        {
                            $options = Array();//옵션설정
                            
                            // $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                            // $options['watermark_sharpness'] = 100;
                            // $options['watermark_pos'] = 4;
                            $options['ratio'] = 1;
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName,$number,$main_image_name['new_name'], $$thumb_str, $width, $height, $main_image_name['type'], $options);
                        }
                        else
                        {
                            $options = Array();//옵션설정
                            $options['save_quality'] = 100;
                            saveThumbFile2($daumEditorDir, $moduleName, $number, $main_image_name['new_name'], $$thumb_str, $width, $height, $main_image_name['type']);
                        }
                    }
                }  
            }               
            
            if($file_name_1 != "" && $file_name_1['name'] != "")
            {
                saveAttFile($daumEditorDir, $moduleName,$number,$file_name_1['tmp_name'],$file_name_1['new_name']);
            }
            if($file_name_2 != "" && $file_name_2['name'] != "")
            {
                saveAttFile($daumEditorDir, $moduleName,$number,$file_name_2['tmp_name'],$file_name_2['new_name']);    
            }
            if($file_name_3 != "" && $file_name_3['name'] != "")
            {
                saveAttFile($daumEditorDir, $moduleName,$number,$file_name_3['tmp_name'],$file_name_3['new_name']);    
            }  
            
            if(sizeof($fileArray))
            {
                reset($fileArray);
                foreach($fileArray as $board_title_en => $fileData)
                {
                    saveAttFile($daumEditorDir, $moduleName,$number,$fileData['tmp_name'],$fileData['new_name']);
                }
            }
            
            $imageUrl = $_POST['tx_attach_imageurl'];
            $filename = $_POST['tx_attach_filename'];
            $fileSize = $_POST['tx_attach_filesize'];
            
            $board_control->updateEditorFile($title_en, $number, $imageUrl, $filename, $fileSize, $boardData['content_watermark_yn']);
            
            if($boardData['content_watermark_yn'] == "Y")
            {
                // imageUrl : http://g-maker.com/upload/board_board1/24/20100903144227260
                // filename : _MOO8875.JPG
                // module_name : board_board1
                $options = Array();//옵션설정
                $options['watermark_path_file'] = $boardData['watermark_img'];//워터마크 이미지
                for($i=0; $i < sizeof($imageUrl); $i++)
                {
                    watermarkFile($imageUrl[$i], $options);
                }
            }
            /////////////////////////////////////////////////////////////////////////////////
            // #process 옵션 부분 처리 내용이 필요하다.
           	$selectNumArray = $_POST['selectNum'];
            $usageArray = $_POST['usage'];
            $formatArray = $_POST['format'];
            $toolsArray = $_POST['tools'];
            $resolutionArray = $_POST['resolution'];
            $sizeArray = $_POST['size'];
            $priceArray = $_POST['price'];
            $sale_priceArray = $_POST['sale_price'];
            $pointArray = $_POST['point'];
            
            for($i=0; $i < sizeof($selectNumArray); $i++)
            {
                $selectNum = intval($selectNumArray[$i]);
                
                $option_file_name = $_FILES['option_file_'.$selectNum];
                
                $optionFileArray['new_name'] = date("YmdHis").makeRandomString(4);                                        
                $optionFileArray['size'] = $option_file_name["size"];
                $optionFileArray['name'] = $option_file_name["name"];
                $optionFileArray['type'] = $option_file_name["type"];
                $optionFileArray['tmp_name'] = $option_file_name["tmp_name"];
                
                if($selectNum < 10000)
                {
                    $real_name = $_POST["real_option_file_".$selectNum];
                    if($optionFileArray["name"] == "" && $real_name == "")
                    {
                        $optionFileArray = "delete";
                    }
                
                    $board_control->updateOptionData($title_en, $number, $selectNum, $usageArray[$i], $formatArray[$i], $toolsArray[$i], $resolutionArray[$i], $sizeArray[$i], $priceArray[$i], $sale_priceArray[$i], $pointArray[$i], $optionFileArray);                            
                }
                else
                {
                    $board_control->insertOptionData($title_en, $number, $usageArray[$i], $formatArray[$i], $toolsArray[$i], $resolutionArray[$i], $sizeArray[$i], $priceArray[$i], $sale_priceArray[$i], $pointArray[$i], $optionFileArray);   
                }
                
                if($optionFileArray != "" && $optionFileArray['name'] != "")
                {
                    saveAttFile($daumEditorDir, $moduleName,$number,$optionFileArray['tmp_name'],$optionFileArray['new_name']);
                }                    
            }
        }
        //alert("글수정에 성공하였습니다.");
        $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&category=".$category_type."&mode=list";    
    }
    else if($actionType == "board_reply")
    {        
       /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
       // - number
       // - password
       // - secret_yn
       // - user_name
       // - email
       // - phone
       // - password : 패스워드 정보
       
       if($ss_idx == "")
       {
           if($_SESSION["ss_captcha"] != $captcha)
           {
                alert("인증번호 입력에 실패하였습니다.", "back");
                $isCheckOK = false;
                exit;     
           }        
       } 
              
        $insert_id = $board_control->replyDataByASC($title_en, $number, $title, $tx_contents, $_SESSION['ss_user_idx']
                                                        , $user_name
                                                        , $email
                                                        , $phone
                                                        , $password);
        if( !$insert_id )
        {
            alert("답글에 실패했습니다.");
        }
        else
        {
            $imageUrl = $_POST['tx_attach_imageurl'];
            $filename = $_POST['tx_attach_filename'];
            $fileSize = $_POST['tx_attach_filesize'];
            
            $board_control->updateEditorFile($title_en, $number, $imageUrl, $filename, $fileSize);
        }
        //alert("답글에 성공하였습니다.");
        $directUrl = $baseUrl."sub.php?code=".$code."&category=".$category_type."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=list";
    }
    else if($actionType == "board_reply_test")
    {        
       /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
       // - number
       // - password
       // - secret_yn
       // - user_name
       // - email
       // - phone
       // - password : 패스워드 정보
        $insert_id = $board_control->replyDataByASC_test($title_en, $number, $title, $tx_contents, "", $b_idx, $homepage
                                                        , $user_name
                                                        , $email
                                                        , $phone
                                                        , $password );
        if( !$insert_id )
        {
            alert("답글에 실패했습니다.");
        }
        else
        {
            $imageUrl = $_POST['tx_attach_imageurl'];
            $filename = $_POST['tx_attach_filename'];
            $fileSize = $_POST['tx_attach_filesize'];
            
            $board_control->updateEditorFile($title_en, $number, $imageUrl, $filename, $fileSize);
            
            $common_model->updateCommonData($old_table, array("insert_yn" => "Y"), array("b_idx" => $b_idx) );
        }
        
        $directUrl = $baseUrl."board_reply_guest_2.php";    
    }
    else if($actionType == "board_delete")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - idx
        // - title_en
         
        /////////////////////////////////////////////////////////////////////////////////
        // #process 메뉴 추가 하기
        
        $isSuccess = $board_control->deleteSubTableAfterAuthCheck($title_en, $number);
       
       if($isSuccess)
       {
            //alert("게시판 정보를 삭제하였습니다.");
       }
       else
       {
            alert("게시판 정보를 삭제하지못했습니다.");
       }
       $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&category=".$category."&mode=list";
    }
    else if($actionType == "port_delete")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - idx
        // - title_en
         
        /////////////////////////////////////////////////////////////////////////////////
        // #process 메뉴 추가 하기
        
        $isSuccess = $board_control->deleteSubTableAfterAuthCheck($title_en, $idx);
       
       if($isSuccess)
       {
            //alert("게시판 정보를 삭제하였습니다.");
       }
       else
       {
            alert("게시판 정보를 삭제하지못했습니다.");
       }
       $directUrl = $_SERVER['HTTP_REFERER'];
    }
    else if($actionType == "board_comment")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - number
        // - code
        // - searchType
        // - search
        // - page
        // - category
        // - c_page
        // - comment_text
        if(!isset($member_control))
        {
        	require_once($baseDir."member/member_control.php");                                            // <= here
        	$member_control = new Member_control();                
        	if( $debugLocal == "Y" | false)
        	{
        		$member_control->debugModeOn();		
        	}
        }
        $isLogin = $member_control->isLogin();
        
        if($isLogin)
        {
            $isSuccess = $board_control->insertCommentData($title_en, $number, $_SESSION['ss_user_idx'], $comment_text);
            
            if( !$isSuccess )
            {      
                alert("댓글에 실패했습니다.");
                $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$number."&password=".$password."&c_page=".$c_page;
            }
            else
            {
                $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$number."&password=".$password."&c_page=".$c_page;
            }     
        }
        else
        {
            alert("회원만이 댓글을 쓸 수 있습니다.");
            $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$number."&password=".$password."&c_page=".$c_page;            
        }
    }
    else if($actionType == "board_comment2")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - comment_text : 
        // - w : c
        // - title_en :
        // - board_num :
        // - comment_id : 
        // - code : 
        // - searchType : 
        // - search :
        // - page :
        // - category : 
        // - c_page :
        // - comment_text :
        // - secret_yn : Y
        if(!isset($member_control))
        {
        	require_once($baseDir."member/member_control.php");                                            // <= here
        	$member_control = new Member_control();                
        	if( $debugLocal == "Y" | false)
        	{
        		$member_control->debugModeOn();		
        	}
        }
        $isLogin = $member_control->isLogin();
        
        /if($isLogin)
        {
            $isSuccess = false;
            if($w == "c")
            {
                if($comment_id == "")
                {
                    $isSuccess = $board_control->insertCommentData($title_en, $board_num, $_SESSION['ss_user_idx'], $comment_text, $secret_yn);    
                }
                else
                {
                    $isSuccess = $board_control->replyCommentData($title_en, $board_num, $_SESSION['ss_user_idx'], $comment_text, $comment_id, $secret_yn);
                }                    
            }
            else if($w == "cu")
            {
                $isSuccess = $board_control->updateCommentData($comment_id, $comment_text, $secret_yn);
            }
            
            
            if( !$isSuccess )
            {      
                alert("댓글에 실패했습니다.");
                $directUrl = $_SERVER['HTTP_REFERER'];
                //$directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$board_num."&password=".$password."&c_page=".$c_page;
            }
            else
            {
                $directUrl = $_SERVER['HTTP_REFERER'];
                //$directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$board_num."&password=".$password."&c_page=".$c_page;
            }     
        }

        else
        {
            alert("회원만이 댓글을 쓸 수 있습니다.");
            $directUrl = $_SERVER['HTTP_REFERER'];
            //$directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$board_num."&password=".$password."&c_page=".$c_page;            
        }


    }
    else if($actionType == "password")
    {
       /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
       
        /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
        $isSuccess = $board_control->isBoardCheckPassword($title_en, $board_num, $password);
        if( !$isSuccess )
        {
            alert("암호가 틀렸습니다.");
            $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&category=".$category."&page=".$page."&mode=list";
        }
        else
        {
            $directUrl = "";
        }        
    }
    else if($actionType == "modify_password")
    {
       /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
       
        /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
        $isSuccess = $board_control->isBoardCheckPassword_modify($title_en, $board_num, $password);
        if( !$isSuccess )
        {
            alert("암호가 틀렸습니다.");
            $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$board_num;
        }
        else
        {
            $directUrl = ""; 
        }        
    }
    else if($actionType == "delete_password")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - idx
        // - title_en
         
        $isSuccess = $board_control->isBoardCheckPassword_modify($title_en, $board_num, $password);
        if( !$isSuccess )
        {
            alert("암호가 틀렸습니다.");
            $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&category=".$category."&page=".$page."&mode=view&board_num=".$board_num;
        }
        else
        {
            $isSuccess = $board_control->deleteSubTable($title_en, $board_num);
            if($isSuccess)
           {
                //alert("게시판 정보를 삭제하였습니다.");
           }
           else
           {
                alert("게시판 정보를 삭제하지못했습니다.");
           }             
            $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&category=".$category."&page=".$page."&mode=list"; 
        }        
    }
    else if($actionType == "reply_password")
    {
       /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
       
        /////////////////////////////////////////////////////////////////////////////////
       // #request POST
       // - title_en
       // - title
       // - tx_contents
        $isSuccess = $board_control->isBoardCheckPassword($title_en, $board_num, $password);
        if( !$isSuccess )
        {
            alert("암호가 틀렸습니다.");
            $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$board_num;
        }
        else
        {
            $directUrl = ""; 
        }        
    }
    else if($actionType == "attribute_update")
    {        
        $title_enArray = $_POST['title_en'];
        $title_koArray = $_POST['title_ko'];
        $selectNumArray = $_POST['selectNum'];
        $field_typeArray = $_POST['field_type'];
        $datasArray = $_POST['datas'];
        $sizeArray = $_POST['size'];
        
        for($i=0; $i < sizeof($selectNumArray); $i++)
        {
            $selectNum = intval($selectNumArray[$i]);
            $display_yn_name = "display_yn_".$selectNumArray[$i];
            $necessary_yn_name = "necessary_yn_".$selectNumArray[$i];
            $display_yn = $$display_yn_name;
            $necessary_yn = $$necessary_yn_name;
                            
            if($selectNum < 10000)
            {
                $board_control->updateTypeData($selectNum, $title_enArray[$i], $title_koArray[$i], $field_typeArray[$i], $datasArray[$i], $sizeArray[$i], $display_yn, $necessary_yn);        
            }
            else
            {
                $board_control->insertTypeData($number, $title_enArray[$i], $title_koArray[$i], $field_typeArray[$i], $datasArray[$i], $sizeArray[$i], $display_yn, $necessary_yn);   
            }                    
        }
        
        alert("게시판 속성 정보를 수정하였습니다.");
        $directUrl = $baseUrl."gadmin/index.php?menu=board&submenu=board_list";           
    }      
    else if($actionType == "comment_delete")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - idx
        // - title_en
        // - number
        // - code
        // - c_page
        // - comment_num
        // - category_type
         
        /////////////////////////////////////////////////////////////////////////////////
        // #process 게시판 삭제하기
        $isSuccess = $board_control->deleteCommentData($comment_num);
       
       if($isSuccess)
       {
            //alert("댓글 정보를 삭제하였습니다.");
       }
       else
       {
            alert("댓글 정보를 삭제하지못했습니다.");
       }                
                                                  
        $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$number."&password=".$password."&c_page=".$c_page;

        /*
                $isSuccess = $board_control->insertComment($_SESSION['ss_user_idx'], $number, $comment_text, $title_en);
        if( !$isSuccess )
        {      
            alert("댓글에 실패했습니다.");
            $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$number."&password=".$password."&c_page=".$c_page;
        }
        else
        {
            $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$number."&password=".$password."&c_page=".$c_page;
        } 
        */                       
    }
    else if($actionType == "comment_delete_list")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - idx
        // - title_en
        // - number
        // - code
        // - c_page
        // - comment_num
        // - category_type
         
        /////////////////////////////////////////////////////////////////////////////////
        // #process 게시판 삭제하기
        $isSuccess = $board_control->deleteCommentData($comment_num);
       
       if($isSuccess)
       {
            //alert("댓글 정보를 삭제하였습니다.");
       }
       else
       {
            alert("댓글 정보를 삭제하지못했습니다.");
       }                
                                                  
        $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=".$mode."&board_num=".$number."&password=".$password."&c_page=".$c_page;

    }
    else if($actionType == "checkFormTitleEn")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - title_en
        
        if($title_en == "")
        {
            alert("영문명을 입력하세요.", "back");
        }
        
        $isSuccess = "";
        if( $debugLocal == "Y" || false)
        {
            echo "title_en (720) : [".$title_en."]<br />";
        }
        /////////////////////////////////////////////////////////////////////////////////
        // #process 메뉴 수정 하기
        if( $board_control->isCheckTitleEn($title_en) )
        {
            $isSuccess = "Y";
        }   
        else
        {
            $isSuccess = "N";
        }                                         
    }
    else if($actionType == "field_modify")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - title_en
        // - number
        // - code
        // - searchType
        // - search
        // - page
        // - category
        // - c_page
        // - comment_num
        // - mode
        // - field_name
        // - field_value
        // - category_type
        // - complete_type
        // - issue_type
        // - comment
        if($title_en == "")
        {
            alert("영문명을 입력하세요.", "back");
        }
        
        $isSuccess = $board_control->updateFieldData($title_en, $number, $field_name, $field_value);
        
        if($isSuccess)
        {
            alert("수정 하였습니다.");
        }
        else
        {
            alert("수정에 실패 했습니다.");
        }
       
        $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$number."&password=".$password."&c_page=".$c_page;
    }
    else if($actionType == "listpage_field_modify")
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - title_en
        // - number
        // - code
        // - searchType
        // - search
        // - page
        // - category
        // - c_page
        // - comment_num
        // - mode
        // - field_name
        // - field_value
        // - category_type
        // - complete_type
        // - issue_type
        // - comment
        if($title_en == "")
        {
            alert("영문명을 입력하세요.", "back");
        }
        
        $isSuccess = $board_control->updateFieldData($title_en, $number, $field_name, $field_value);
        
        if($isSuccess)
        {
            alert("수정 하였습니다.");
        }
        else
        {
            alert("수정에 실패 했습니다.");
        }
       
        $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=list&board_num=".$number."&password=".$password."&c_page=".$c_page;
    }
    else if($actionType == "auction_delete")
    {   // 경매한 정보 삭제
        if(!isset($form_control))
        {
            require_once($baseDir."form/form_control.php");
            $form_control = new Form_control();
            if( $debugLocal == "Y" || false)
        	{
        		$form_control->debugModeOn();		
        	}                
        }
        /////////////////////////////////////////////////////////////////////////////////
        // #request POST
        // - number : 4
        // - code : VJB5uVy
        // - auction_idx : 6
        // - searchType
        // - search
        // - page
        // - category
         
        /////////////////////////////////////////////////////////////////////////////////
        // #process 게시판 삭제하기
        $isSuccess = $form_control->deleteFormDataByCode($code, $auction_idx);
       
       if($isSuccess)
       {
            alert("경매 정보를 삭제하였습니다.");
       }
       else
       {
            alert("경매 정보를 삭제하지못했습니다.");
       }                
                                                  
        $directUrl = $baseUrl."sub.php?code=".$code."&searchType=".$searchType."&search=".$search."&page=".$page."&mode=view&board_num=".$number."&password=".$password."&c_page=".$c_page;

    }
               
    /////////////////////////////////////////////////////////////////////////////////
    // #process                  
    if( $debugLocal == "Y" || false)
    {
        echo "directUrl : [".$directUrl."]<br />";
        exit;
    } 
    
    if($directUrl == "")
    {
    }
    else
    {
        /////////////////////////////////////////////////////////////////////////////////
        // #direct            
        //gogo_replace($directUrl);
        echo "<meta http-equiv=\"refresh\" content=\"0;url='".$directUrl."'\">";    
        exit;
    }    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>
</head>
<body>	
<?php
    if($actionType == "checkFormTitleEn")
    {
?>
<form name="currentForm" method="post" action="<?php echo($baseUrl);?>board/checkId.php">
    <input type="hidden" name="title_en" value="<?php echo($title_en); ?>" />
    <input type="hidden" name="isSuccess" value="<?php echo($isSuccess); ?>" />
</form>
<?
    }
    else if($actionType == "password")
    {
?>
<form name="currentForm" method="post" action="<?php echo($baseUrl);?>sub.php">
    <input type="hidden" name="code" value="<?php echo($code); ?>" />
    <input type="hidden" name="searchType" value="<?php echo($searchType); ?>" />
    <input type="hidden" name="search" value="<?php echo($search); ?>" />
    <input type="hidden" name="category" value="<?php echo($category); ?>" />
    <input type="hidden" name="page" value="<?php echo($page); ?>" />
    <input type="hidden" name="mode" value="view" />
    <input type="hidden" name="board_num" value="<?php echo($board_num); ?>" />
    <input type="hidden" name="password" value="<?php echo($password); ?>" />
</form>
<?        
    }
    else if($actionType == "modify_password")
    {
?>
<form name="currentForm" method="post" action="<?php echo($baseUrl);?>sub.php">
    <input type="hidden" name="code" value="<?php echo($code); ?>" />
    <input type="hidden" name="searchType" value="<?php echo($searchType); ?>" />
    <input type="hidden" name="search" value="<?php echo($search); ?>" />
    <input type="hidden" name="category" value="<?php echo($category); ?>" />
    <input type="hidden" name="page" value="<?php echo($page); ?>" />
    <input type="hidden" name="mode" value="modify" />
    <input type="hidden" name="board_num" value="<?php echo($board_num); ?>" />
    <input type="hidden" name="password" value="<?php echo($password); ?>" />
</form>
<?        
    }
    else if($actionType == "reply_password")
    {
?>
<form name="currentForm" method="post" action="<?php echo($baseUrl);?>sub.php">
    <input type="hidden" name="code" value="<?php echo($code); ?>" />
    <input type="hidden" name="searchType" value="<?php echo($searchType); ?>" />
    <input type="hidden" name="search" value="<?php echo($search); ?>" />
    <input type="hidden" name="category" value="<?php echo($category); ?>" />
    <input type="hidden" name="page" value="<?php echo($page); ?>" />
    <input type="hidden" name="mode" value="reply" />
    <input type="hidden" name="board_num" value="<?php echo($board_num); ?>" />
    <input type="hidden" name="password" value="<?php echo($password); ?>" />
</form>
<?        
    }
?>

<script language="javascript">
    var form = document.currentForm;
    form.submit();
</script>
</body>
</html>