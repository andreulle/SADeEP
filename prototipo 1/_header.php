<?php if($page != "home"){ ?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Project name</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="<?php if($page == "principal") echo "active" ?>">
					<a href="<?php echo $url ?>principal">Home</a>
				</li>
				<li class="<?php if($page == "lancamentos") echo "active" ?>">
					<a href="<?php echo $url ?>lancamentos">Lançamentos</a>
				</li>
				<li class="<?php if($page == "relatorios") echo "active" ?>">
					<a href="<?php echo $url ?>relatorios">Relatórios</a>
				</li>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>