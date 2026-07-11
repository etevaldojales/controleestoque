<div class="tm-paginator" style="width:auto; float:right; margin-bottom:20px; margin-top:15px;">
<?php
$paginacao = '';
if ($pag>1)
{
    $paginacao = '<a href="javascript: void(0)" class="prev page-numbers" style="margin-right:3px;" onclick="paginar('.$ant.')">Previous</a>';
}
if ($ultima_pag <= 5)
{
	for ($i=1; $i< $ultima_pag+1; $i++)
	{
		if ($i == $pag)
		{
			$paginacao .= '<span class="page-numbers current" style="margin-right:3px;" >'.$i.'</span>';				
		} else {
			$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar('.$i.')">'.$i.'</a>';	
		}
	}
} 

if ($ultima_pag > 5)
{
	if ($pag < 1 + (2 * $adjacentes))
	{
		for ($i=1; $i< 2 + (2 * $adjacentes); $i++)
		{
			if ($i == $pag)
			{
				$paginacao .= '<span class="page-numbers current" style="margin-right:3px;">'.$i.'</span>';				
			} else {
				$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar('.$i.')">'.$i.'</a>';	
			}
		}
		$paginacao .= '...';
		$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar('.$penultima.')">'.$penultima.'</a>';
		$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar('.$ultima_pag.')">'.$ultima_pag.'</a>';
	}
	elseif($pag > (2 * $adjacentes) && $pag < $ultima_pag - 3)
	{
		$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar(1)">1</a>';				
		$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar(1)">2</a> ... ';	
		for ($i = $pag-$adjacentes; $i<= $pag + $adjacentes; $i++)
		{
			if ($i == $pag)
			{
				$paginacao .= '<span class="page-numbers current" style="margin-right:3px;">'.$i.'</span>';				
			} else {
				$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar('.$i.')">'.$i.'</a>';	
			}
		}
		$paginacao .= '...';
		$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar('.$penultima.')">'.$penultima.'</a>';
		$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar('.$ultima_pag.')">'.$ultima_pag.'</a>';
	}
	else {
		$paginacao .= '<a href="javascript: void(0)" class="page-numbers"  style="margin-right:3px;" onclick="paginar(1)">1</a>';				
		$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar(1)">2</a> ... ';	
		for ($i = $ultima_pag - (4 + (2 * adjacentes)); $i <= $ultima_pag; $i++)
		{
			if ($i == $pag)
			{
				$paginacao .= '<span class="page-numbers current" style="margin-right:3px;">'.$i.'</span>';				
			} else {
				$paginacao .= '<a href="javascript: void(0)" class="page-numbers" style="margin-right:3px;" onclick="paginar('.$i.')">'.$i.'</a>';	
			}
		}
	}
}
if ($prox <= $ultima_pag && $ultima_pag > 2)
{
$paginacao .= '<a href="javascript: void(0)" class="next page-numbers" style="margin-right:3px;" onclick="paginar('.$prox.')">Next</a>';
}
echo $paginacao;
?>
</div>
