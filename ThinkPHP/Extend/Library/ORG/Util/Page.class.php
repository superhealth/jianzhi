<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// |         lanfengye <zibin_5257@163.com>
// +----------------------------------------------------------------------

class Page {
    
    // 分页栏每页显示的页数
    public $rollPage = 10;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 分页URL地址
    public $url     =   '';
    // 默认列表每页显示行数
    public $listRows = 10;
    // 起始行数
    public $firstRow    ;
    // 分页总页面数
    public $totalPages  ;
    // 总行数
    public $totalRows  ;
    // 当前页数
    public $nowPage    ;
    // 分页的栏的总页数
    public $coolPages   ;
    // 分页显示定制
    protected $config  =    array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'首页','last'=>'尾页','theme'=>'<ul>%prePage% %upPage% %first% %linkPage% %end% %downPage% %nextPage%</ul>');
    
    // 默认分页变量名
    protected $varPage;

    /**
     * 架构函数
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows,$listRows='',$parameter='',$url='') {
        $this->totalRows    =   $totalRows;
        $this->parameter    =   $parameter;
        $this->varPage      =   C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
        if(!empty($listRows)) {
            $this->listRows =   intval($listRows);
        }
        $this->totalPages   =   ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages    =   ceil($this->totalPages/$this->rollPage);
        $this->nowPage      =   !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if($this->nowPage<1){
            $this->nowPage  =   1;
        }elseif(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage  =   $this->totalPages;
        }
        $this->firstRow     =   $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     * 分页显示输出
     * @access public
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage;
        $nowCoolPage    =   ceil($this->nowPage/$this->rollPage);

        // 分析分页参数
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__';
        }else{
            if($this->parameter && is_string($this->parameter)) {
                parse_str($this->parameter,$parameter);
            }elseif(is_array($this->parameter)){
                $parameter      =   $this->parameter;
            }elseif(empty($this->parameter)){
                unset($_GET[C('VAR_URL_PARAMS')]);
                $var =  !empty($_POST)?$_POST:$_GET;
                if(empty($var)) {
                    $parameter  =   array();
                }else{
                    $parameter  =   $var;
                }
            }
            $parameter[$p]  =   '__PAGE__';
            $url            =   U('',$parameter);
        }
        //上下翻页字符串
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;
        if ($upRow>0){
            $upPage     =   "<li><a class='p_prev' href='".str_replace('__PAGE__',$upRow,$url)."' title='上一页'>".$this->config['prev']."</a></li>";
        }else{
            $upPage     =   '';
        }

        if ($downRow <= $this->totalPages){
            $downPage   =   "<li><a class='p_next' href='".str_replace('__PAGE__',$downRow,$url)."' title='下一页'>".$this->config['next']."</a></li>";
        }else{
            $downPage   =   '';
        }
        // << < > >>
        if($nowCoolPage == 1){
            $theFirst   =   '';
            $prePage    =   '';
        }else{
            $preRow     =   $this->nowPage-$this->rollPage;
            $prePage    =   "<li><a class='p_up' href='".str_replace('__PAGE__',$preRow,$url)."' title='前".$this->rollPage."页'>前翻</a></li>";
            $theFirst   =   "<li><a class='p_first' href='".str_replace('__PAGE__',1,$url)."' title='首页' >".$this->config['first']."</a></li>";
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage   =   '';
            $theEnd     =   '';
        }else{
            $nextRow    =   $this->nowPage+$this->rollPage;
            $theEndRow  =   $this->totalPages;
            $nextPage   =   "<li><a class='p_down' href='".str_replace('__PAGE__',$nextRow,$url)."' title='后".$this->rollPage."页' >后翻</a></li>";
            $theEnd     =   "<li><a class='p_last' href='".str_replace('__PAGE__',$theEndRow,$url)."' title='最后一页' >".$this->config['last']."</a></li>";
        }
        // 1 2 3 4 5
        $linkPage = "";
        for($i=1;$i<=$this->rollPage;$i++){
            $page       =   ($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $linkPage .= "<li><a href='".str_replace('__PAGE__',$page,$url)."'>".$page."</a></li>";
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $linkPage .= "<li class='active'><a class='p_active' href='#'>".$page."</a></li>";
                }
            }
        }
        $pageStr     =   str_replace(
            array('%prePage%','%upPage%','%first%','%linkPage%','%end%','%downPage%','%nextPage%'),
            array($prePage,$upPage,$theFirst,$linkPage,$theEnd,$downPage,$nextPage),$this->config['theme']);
        return $pageStr;
    }

    /**
     * 自定义show()方法
     */
    public function shown(){
    	$start = $this->firstRow+1;
    	$end = $this->firstRow+$this->listRows>$this->totalRows ? $this->totalRows : $this->firstRow+$this->listRows;
    	return array(
    		'header'	=> $end==0 ? '' : "显示第{$start}-{$end}项，共{$this->totalRows}项.",
    		'show'	=> $this->show()
    	);
    }
}