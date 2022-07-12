<?php 

$this->title = 'Admin';

?>

<h1>Cписок добавленных URL:</h1>
<table style="width: 100%; border:1px solid black;">
	<tbody>
		<tr style="border:1px solid black;text-align: center;">
			<td style="width:15%;font-weight:bold;border:1px solid black;">Дата создания</td>
			<td style="width:35%;font-weight:bold;border:1px solid black;">URL</td>
			<td style="width:25%;font-weight:bold;border:1px solid black;">Частота проверки</td>
			<td style="width:25%;font-weight:bold;border:1px solid black;">Количество повторов</td>			
		</tr>
        <?php foreach ($links as $link) :?>        
		<tr style="border:1px solid black;">            
			<td style="border:1px solid black;">
                <?= $link->created_at;?>
            </td>
			<td style="border:1px solid black;">
                <?= $link->link;?>
            </td style="border:1px solid black;">
			<td style="border:1px solid black;">
                раз в <?= $link->period;?> мин
            </td>
			<td style="border:1px solid black;">
                <?= $link->repeating;?>
            </td>			
		</tr>
        <?php endforeach; ?>
	</tbody>
</table>

<br><br>

<h1>Cписок проверок:</h1>
<table style="width: 100%; border:1px solid black;">
	<tbody>
		<tr style="border:1px solid black;text-align: center;">
			<td style="width:15%;font-weight:bold;border:1px solid black;">Дата проверки</td>
			<td style="width:35%;font-weight:bold;border:1px solid black;">URL</td>
			<td style="width:35%;font-weight:bold;border:1px solid black;">HTTP код</td>
			<td style="width:15%;font-weight:bold;border:1px solid black;">Номер попытки</td>			
		</tr>
        <?php foreach ($links as $link) :?>        
		<tr style="border:1px solid black;">            
			<td style="border:1px solid black;">
                <?= $link->checked_at;?>
            </td>
			<td style="border:1px solid black;">
                <?= $link->link;?>
            </td style="border:1px solid black;">
			<td style="border:1px solid black;">
                <?= $link->http;?>
            </td>
			<td style="border:1px solid black;">
                <?= $link->attempt;?>
            </td>			
		</tr>
        <?php endforeach; ?>
	</tbody>
</table>