<?php 
$childPages = isset($childPages) ? $childPages : $this->params['childPages'];
if(!empty($childPages)){
	
/* Old Way to build the nav
echo '
<table>';
foreach($childPages as $childPageTitle=>$childPageUrl){
	echo "
	<tr>
		<td>".$html->link($childPageTitle, $childPageUrl, array('class'=>'body_lf'))."</td>
	</tr>";
}
echo '
</table>
';

*/
//New Way
$subNav_array = array();
foreach($childPages as $childPageTitle=>$childPageUrl){
	$subNav_array[$childPageTitle] = $childPageUrl;
}

echo $navigation->create($subNav_array, array('id' => 'subNavigation'));
}

/*
<div class="edit-this">',
     $html->link('Edit', array('controller' => $controller, 'action' => 'edit', 'admin' => 1, $id)),
     '</div>';	
 */

?>