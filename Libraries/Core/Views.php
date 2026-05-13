<?php 
	
	class Views
	{
		function getView($controller,$view,$data="")
		{
			$controller = get_class($controller);
			if($controller == "Home"){
				$view = "Views/App/".$view.".php";
			}else{
				$view = "Views/App/".$controller."/".$view.".php";
			}
			require_once ($view);
		}
	}

 ?>