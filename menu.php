<?php
$_secoes = new secoes($dbase);
$wheresec = "where u.id_usuario = ".$_SESSION["usuario"];
$ordemsec = "order by posicao";

$secoes  = $_secoes->getSecoes($wheresec,$ordemsec); 
$current_page = basename($_SERVER['PHP_SELF']);

function is_page_active($url, $current_page) {
    $path = parse_url($url, PHP_URL_PATH);
    return basename($path) == $current_page;
}
?>
<ul class="sidebar-menu">
    <?php
	if(is_array($secoes)) {
		foreach($secoes as $s) {
			if($s['url']) {
				$active_class = is_page_active($s['url'], $current_page) ? 'active' : '';
			?>
				<li class="<?=$active_class?>"><a class="" href="<?=$s['url']?>"><span class="icon-box"><i class="<?=$s['icone']?>"></i></span><?=$s['secao']?></a></li>
			<?php
			}
			else {
                $wheresubsec = "where u.id_usuario = ".$_SESSION["usuario"]." and sb.id_secao = ".$s['id'];
                $ordemsubsec = "order by sb.id";
                $subsecoes = $_secoes->getSubsecoes($wheresubsec,$ordemsubsec);

                $has_active_sub = false;
                if(is_array($subsecoes)) {
                    foreach($subsecoes as $sc) {
                        if(is_page_active($sc['url'], $current_page)) {
                            $has_active_sub = true;
                            break;
                        }
                    }
                }

                $parent_class = "has-sub" . ($has_active_sub ? " active" : "");
                $arrow_class = "arrow" . ($has_active_sub ? " open" : "");
			?>
            <li class="<?=$parent_class?>">
                <a href="javascript:;" class="">
                    <span class="icon-box"> <i class="<?=$s['icone']?>"></i></span> <?=$s['secao']?>
                    <span class="<?=$arrow_class?>"></span>
                </a>
                <ul class="sub">
                    <?php
                    if(is_array($subsecoes)) {
                        foreach($subsecoes as $sc) {
                            $sub_active_class = is_page_active($sc['url'], $current_page) ? 'active' : '';
                        ?>
                        <li class="<?=$sub_active_class?>"><a class="" href="<?=$sc['url']?>">&raquo;&raquo; <?=$sc['subsecao']?></a></li>
                        <?php
                        }
                    }
                    ?>
                </ul>
			</li>                
			<?php	
			}
		}
	}
	?>
    <li>
    	<a class="" href="javascript: void(0)" onclick="document.getElementById('frmgrbck').submit()">
            <span class="icon-box"><i class="icon-save"></i></span>Backup
        </a>
	</li>
</ul>
<iframe name="frmbackup" id="frmbackup" src="#" width="300" height="300" frameborder="0" style="display:none"></iframe>
<form name="frmgrbck" id="frmgrbck" action="backup.php" method="post" target="frmbackup"></form>

