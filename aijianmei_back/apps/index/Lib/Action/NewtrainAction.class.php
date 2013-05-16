<?php
class NewtrainAction extends Action {
    public function index()
    {
		$this->assign('_current', 'train');
        $this->display();
	}
}
?>
