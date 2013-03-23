<?php 
class InfoAction extends Action {

        private $cssFile = 'about_us';

	public function index()
	{
            $this->assign('cssFile',$this->cssFile);
            $this->display();
	}

        public function aboutUs()
        {            
            $this->display('about_us');
            $this->ajaxReturn('123');
        }

/*
 *
 *      public function founders()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function relations()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function media()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function ad()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function adBrand()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display('ad_brand');
        }

        public function direct()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function privacy()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function join()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function payment()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function culture()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function contact()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }

        public function cooperation()
        {
            $this->assign('cssFile',$this->cssFile);
            $this->display();
        }
 *
 *
 */

}
