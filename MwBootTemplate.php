<?php

class MwBootTemplate extends BaseTemplate {

	private $basePath;
	private $basePath1;
	private $shortName = "Wiki";
	private $pageTitle;
	private $wgEnableUploads;
	private $wgUser;
	private $currentPage;

	public function __construct() {
		global $wgEnableUploads, $wgArticlePath,$wgUser;

		$this->basePath = str_replace( '$1', '', $wgArticlePath );
		$this->basePath1 = rtrim($this->basePath, "/");
		$this->wgEnableUploads = $wgEnableUploads;
		$this->wgUser = $wgUser;
	}
	
	public function execute() {

		$this->pageTitle = $this->getSkin()->getTitle();
		//echo '<pre>'; print_r($this->text( 'logopath' ));
		//echo '<pre>'; print_r($this->pageTitle->getLinkURL());
		$this->currentPage = str_replace("/index.php/", "", $this->pageTitle->getLinkURL());
		//echo $this->currentPage;
		$this->html('headelement');
		$this->topNavigation();
		$this->startContent();
		

		?>

		<div class="row">
			<div class="col-md-9">

			<?php

			if ($this->pageTitle->isMainPage()){

				$this->homeSearch();
       			echo '<div class="well">';
       			echo $this->homeLinks( $this->get_page_links( 'Bootstrap:Home' ));
       			echo '</div>';
      
    	} else {
    		//echo '';
    		//echo $this->get_array_links( $this->data['content_actions'], 'Page', 'page' );


    		?>

<?php if ( $this->wgUser->isLoggedIn() ) { ?>
<ul class="nav nav-tabs">
<?php foreach ($this->data['content_actions'] as $key => $value) { ?>

<?php if ($key !== 'talk') { ?>
	<li class="nav-item">
    <a class="nav-link <?php echo ($value['class'] == 'selected') ? 'active' : ''; ?>" href="<?php echo $value['href'] ?>"><?php echo $value['text'] ?></a>
  </li>
<?php } ?>
<?php } ?>
</ul>
<?php } ?>
<div id="content">
<div class="well">
<div class="page-header">
<h1 id="firstHeading" class="firstHeading"><?php $this->html( 'title' ); ?></h1>
</div>
<div id="contentSub"></div>
<div id="bodyContent">


    		<?php





       		echo $this->html( 'bodycontent' );
       		echo '</div></div></div>';
       
    }
			
			 ?>
			
				
			


			</div>
			<div class="col-md-3">
				<?php echo $this->sidebar(); ?>
			</div>
		</div>
		<hr>
		<?php echo $this->footer(); ?>
		</div>
		</body>
		</html>
		<?php
	}




 private function topNavigation(){ ?>
	<nav class="navbar navbar-toggleable-md navbar-inverse bg-primary">
	<div class="container">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleContainer" aria-controls="navbarsExampleContainer" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>">
		<?php echo $this->shortName; ?>
	</a>
	<div class="collapse navbar-collapse" id="navbarsExampleContainer">
	<ul class="navbar-nav mr-auto">
	<li class="nav-item">
	<a class="nav-link" href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>">Home</a>
	</li>
	<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tools</a>
	<div class="dropdown-menu" aria-labelledby="dropdown02">
	<a class="dropdown-item" href="<?php echo $this->basePath; ?>Special:RecentChanges"><i class="fa fa-edit"></i> Recent Changes</a>
	<a class="dropdown-item" href="<?php echo $this->basePath; ?>Special:SpecialPages" class="special-pages"><i class="fa fa-star-o"></i> Special Pages</a>
	<?php if($this->wgEnableUploads) { ?>
	<a class="dropdown-item" href="<?php echo  $this->basePath; ?>Special:Upload"><i class="fa fa-upload"></i> Upload a File</a>
	<?php } ?>
	</div>
	</li>
	<?php echo $this->nav( $this->get_page_links('Bootstrap:NavBar') ); ?>
	<li class="nav-item">
	<?php if ( $this->wgUser->isLoggedIn() ) { ?>
		<a href="<?php echo $this->basePath1; ?>?title=Special:UserLogout&returnto=<?php echo $this->currentPage; ?>" class="nav-link">Logout</a>
	<?php } else { ?>
		<a href="<?php echo $this->basePath1; ?>?title=Special:UserLogin&returnto=<?php echo $this->currentPage; ?>" class="nav-link">Login</a>
	<?php }?>
	</li>
	</ul>
	<form class="form-inline my-2 my-md-0"  action="<?php $this->text( 'wgScript' ) ?>" id="searchform" role="search">
	<input class="form-control mr-sm-2" type="search" name="search" placeholder="Search wiki" title="Search <?php echo $wgSitename; ?> [ctrl-option-f]" accesskey="f" id="searchInput" autocomplete="off">
	<input type="hidden" name="title" value="Special:Search">
	</form>
	</div>
	</div>
	</nav>
<?php
}


private function homeSearch(){ ?>


<div class="hmeSrhPnl">


<h1><span class="light">Kennedy </span>Wiki</h1>
<p>Have a question? Search here to find document or ask for help.</p>
	<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform2" role="search">
      <input class="form-control form-control-lg mw-search" type="search" name="search" placeholder="Start typing to search" id="searchInput" autocomplete="off">
            
            <input type="hidden" name="title" value="Special:Search">

            <button class="btn btn-lg btn-success" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
          </form>

          </div>

         
         


	
	<?php }



	private function startContent(){
		echo '<div class="container">';
	}

	private function closeHtml(){
		echo "</div></body></html>";
	}


	private function homeLinks($categories) {

		if(!$categories){
			echo "<b>Bootstrap:Home</b> not created."; return;
		}

		$output = '<div class="page-header"><h3>Categories</h3></div><div class="row">';

		foreach ($categories as $category) {
			$output .= '<div class="col-md-6 hcat">';
			$output .= '<h5> <i class="fa fa-folder" aria-hidden="true"></i> '.$category['title'].'</h5>';
			
			foreach ($category['sublinks'] as $link) {
				$output .= '<div class="category_links"><i class="fa fa-file-text-o" aria-hidden="true"></i> <a href="'.$link['link'].'">'.$link['title'].'</a></div>';
			}

			$output .= '</div>';
		}
		$output .= '</div>';

		return $output;
	}




	private function nav($nav) {

		$output = '';
		foreach ( $nav as $topItem ) {
			$pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );
			if ( array_key_exists( 'sublinks', $topItem ) ) {
				$output .= '<li class="nav-item dropdown">';
				$output .= '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">' . $topItem['title'] . ' <b class="caret"></b></a>';
				$output .= '<div class="dropdown-menu">';

				foreach ( $topItem['sublinks'] as $subLink ) {
					if ( 'divider' == $subLink ) {
						$output .= "<li class='divider'></li>\n";
					} elseif ( isset($subLink['textonly']) ) {
						$output .= "<li class='nav-header'>{$subLink['title']}</li>\n";
					} else {
						if( $subLink['local'] && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
							$href = $pageTitle->getLocalURL();
						} else {
							$href = $subLink['link'];
						}//end else

						$slug = strtolower( str_replace(' ', '-', preg_replace( '/[^a-zA-Z0-9 ]/', '', trim( strip_tags( $subLink['title'] ) ) ) ) );
						$output .= "<a class='dropdown-item' href='{$href}'>{$subLink['title']}</a>";
					}//end else
				}
				$output .= '</div>';
				//$output .= '</li>';
			} else {
				if( $pageTitle ) {
					$output .= '<li' . ($this->data['title'] == $topItem['title'] ? ' class="nav-item active"' : ' class="nav-item"') . '><a class="nav-link" href="' . ( $topItem['external'] ? $topItem['link'] : $pageTitle->getLocalURL() ) . '">' . $topItem['title'] . '</a></li>';
				}//end if
			}//end else
		}//end foreach
		return $output;
	}//end nav


	private function get_page_links( $source ) {

		$titleBar = $this->getPageRawText($source);

		if(!$titleBar){
			return false;
		}


		$nav = array();

		foreach(explode("\n", $titleBar) as $line) {
			if(trim($line) == '') continue;
			if( preg_match('/^\*\*\s*divider/', $line ) ) {
				$nav[ count( $nav ) - 1]['sublinks'][] = 'divider';
				continue;
			}//end if

			$sub = false;
			$link = false;
			$external = false;

			if(preg_match('/^\*\s*([^\*]*)\[\[:?(.+)\]\]/', $line, $match)) {
				$sub = false;
				$link = true;
			}elseif(preg_match('/^\*\s*([^\*\[]*)\[([^\[ ]+) (.+)\]/', $line, $match)) {
				$sub = false;
				$link = true;
				$external = true;
			}elseif(preg_match('/^\*\*\s*([^\*\[]*)\[([^\[ ]+) (.+)\]/', $line, $match)) {
				$sub = true;
				$link = true;
				$external = true;
			}elseif(preg_match('/\*\*\s*([^\*]*)\[\[:?(.+)\]\]/', $line, $match)) {
				$sub = true;
				$link = true;
			}elseif(preg_match('/\*\*\s*([^\* ]*)(.+)/', $line, $match)) {
				$sub = true;
				$link = false;
			}elseif(preg_match('/^\*\s*(.+)/', $line, $match)) {
				$sub = false;
				$link = false;
			}

			if(isset($match[2])  && strpos( $match[2], '|' ) !== false ) {
				$item = explode( '|', $match[2] );
				$item = array(
					'title' => $match[1] . $item[1],
					'link' => $item[0],
					'local' => true,
				);
			} else {
				if( $external ) {
					$item = $match[2];
					$title = $match[1] . $match[3];
				} else {
					$m2 = (isset($match[2])) ? $match[2] : '';
					$item = $match[1] . $m2;
					$title = $item;
				}//end else

				if( $link ) {
					$item = array('title'=> $title, 'link' => $item, 'local' => ! $external , 'external' => $external );
				} else {
					$item = array('title'=> $title, 'link' => $item, 'textonly' => true, 'external' => $external );
				}//end else
			}//end else

			if( $sub ) {
				$nav[count( $nav ) - 1]['sublinks'][] = $item;
			} else {
				$nav[] = $item;
			}//end else
		}

		return $nav;	
	}//end get_page_links


	private function getPageRawText($title) {
		global $wgParser, $wgUser;
		$pageTitle = Title::newFromText($title);
		if(!$pageTitle->exists()) {
			return false;
		} else {
			$article = new Article($pageTitle);
			$wgParserOptions = new ParserOptions($wgUser);
			$parserOutput = $wgParser->preprocess($article->getContent( Revision::RAW ), $pageTitle, $wgParserOptions );
			return $parserOutput;
		}
	}


	private function sidebar() { ?>

		<div class="sidebar-well">
			<div class="text-center">
				<img src="<?php echo $this->text( 'logopath' ); ?>" class="img-fluid logo" />
			</div>

			<?php $this->includePage('Bootstrap:Sidebar'); ?>

		</div>

		<?php
	}


	public function footer(){

		$footer = $this->printTrail();
		$footer .= '&copy; Copyright, '.date('Y').' - <a href="https://www.kennedy.ox.ac.uk/" target="_blank">The Kennedy Institute of Rheumatology</a>';
		return $footer;

	}


	public function includePage($title) {
		global $wgParser, $wgUser;
		$pageTitle = Title::newFromText($title);
		if(!$pageTitle->exists()) {
			echo 'The page [[' . $title . ']] was not found.';
		} else {
			$article = new Article($pageTitle);
			$wgParserOptions = new ParserOptions($wgUser);
			$parserOutput = $wgParser->parse($article->getContent( Revision::RAW ), $pageTitle, $wgParserOptions);
			echo $parserOutput->getText();
		}
	}


}
