<!-- Write your html code here (only body's body) -->

<p><?php echo $this->_translator->translate($data['msg']) ?></p>
<br></br>
File app/controller/ExampleController.php:<br><br>

<img src="<?php echo $data['controller']?>" />

<br></br><br>
File app/model/Model.php:<br><br>

<img src="<?php echo $data['model']?>" />

<br></br><br>
File app/view/example/index.php:<br><br>

<img src="<?php echo $data['view']?>" />