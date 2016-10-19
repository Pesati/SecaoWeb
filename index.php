<?php 
	function getUrlContent($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: testconsumerapi'); /* Necessary to auth application */
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); /* TRUE to return the transfer as a string of the return value instead of outputting it out directly. */
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		return ($httpcode >= 200 && $httpcode < 300) ? $data : false;
	}

	if(!empty($_GET['user_name'])){
		$git_url = 'https://api.github.com/users/' . urlencode($_GET['user_name']);
		$git_json = getUrlContent($git_url); 
		$git_array = json_decode($git_json, true);
	}
?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title> SecaoWeb </title>
	</head>
	
	<body>
		<div id="wrapper">

			<h1>WEB app PHP - API do GitHub</h1>
			
				<fieldset>
					<form action="">
						<label for="user_name"> GitHub - Username: </label>
						<input type="text" name="user_name">
						<button type="submit"> Confirma </button>
					</form>
				</fieldset>

			<?php 

				if(!empty($git_json)){ ?>
				
					<h3> Username: </h3>
						<p> <?php echo $git_array["login"]; /* Lista os Usernames */ ?> </p>
					
					<h3> Repositorios: </h3>
						
					<ul>
						<?php 

							$git_repo = getUrlContent($git_array["repos_url"]);
							$git_repo_array = json_decode($git_repo, true); 

							foreach ($git_repo_array as $repo) {
								echo "<li><a href='" . $repo['html_url'] . "' >" . $repo['name'] . '</a></li>'; /* Lista as url's e os nomes dos repositorios*/
							}
						?>
					</ul>

						<?php echo "<img src='" . $git_array["avatar_url"] . "' alt='user-avatar' >"; ?>	

				<?php
					}
				?>
		</div>
	
	</body>

</html>