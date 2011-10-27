<?php
$title_pointer = 0;
$res = array();

$fh = file('results.txt'); 
foreach ($fh as $line_num => $line) {
	if ($line == "") 
		break;
		
	if ($line_num == $title_pointer) {
		$res[$title_pointer]['title'] = $line;
	} else if ($line_num == $title_pointer + 1) {
		$res[$title_pointer]['result'] = $line;
		$end_counter = $res[$title_pointer]['result'];
	} else {
		$line_mood = json_decode(file_get_contents("http://uclassify.com/browse/prfekt/Mood/ClassifyText?readkey=nuKbR4OPYof5Ga9IEtKWBVxnxPA&text=".urlencode($line)."&version=1.01&removehtml=true&output=json"));
		$res[$title_pointer]['mood']['good'] += $line_mood->cls1->happy; 
		$res[$title_pointer]['mood']['bad'] += $line_mood->cls1->upset;
		$end_counter = $end_counter - 1;	

		if ($end_counter == 0) {
			$res[$title_pointer]['mood']['sum'] = $res[$title_pointer]['mood']['good'] + $res[$title_pointer]['mood']['bad'];
			if (!$res[$title_pointer]['mood']['sum']) 
				$res[$title_pointer]['mood']['sum'] = 1;
			$res[$title_pointer]['mood']['good'] = round($res[$title_pointer]['mood']['good'] * 100 / $res[$title_pointer]['mood']['sum'], 0); 
			$res[$title_pointer]['mood']['bad'] = round(100 - $res[$title_pointer]['mood']['good']);			
			$title_pointer = $line_num + 1;
		}		
	}
}
?>

<script type="text/javascript" src="jscharts.js"></script>
<div id="graph1">Pagaidiet!</div>
<script type="text/javascript">
	var myData = new Array(	
	<? $i = 1; foreach ($res as $result) { ?>["<?= trim($result['title']) ?>", <?= trim($result['result']) ?>]<?if($i!=sizeof($res)) {?>,<?}?>

	<? $i++; if ($i == 10) break;} ?>
		);	
	var myChart = new JSChart('graph1', 'bar');
	myChart.setDataArray(myData);
	myChart.setBarColor('#42aBdB');
	myChart.setBarOpacity(0.8);
	myChart.setBarBorderColor('#D9EDF7');
	myChart.setBarValues(false);
	myChart.setTitle('Brendu tops 10 - Kafejnīcas, Kinoteātri, Klubi, Alus šķirnes, Ziņu portāli');
	myChart.setTitleColor('#8C8383');
	myChart.setAxisColor('#777E81');
	myChart.setAxisNameX('');
	myChart.setAxisNameY('');
	myChart.setAxisValuesColor('#777E81');
	myChart.setSize(1000, 321);
	myChart.draw();
</script>

<? $i = 0; foreach ($res as $result) { $i++; ?>
<div style="float:left;" id="a<?=$i?>">Pagaidiet!</div>
<script type="text/javascript">
		var myData = new Array(	
			['Pozitīvs', <?= $result['mood']['good']; ?>], 
			['Negatīvs', <?= $result['mood']['bad']; ?>]
		);	
		var colors = [	
			'#C40000', 
			'#750303'
		];
		
		var myChart = new JSChart('a<?=$i?>', 'pie');
		myChart.setDataArray(myData);
		myChart.colorizePie(colors);
		myChart.setTitle('Noskaņojums - <?=trim($result['title'])?>');
		myChart.setTitleColor('#8E8E8E');
		myChart.setTitleFontSize(11);
		myChart.setTextPaddingTop(20);
		myChart.setSize(308, 200);
		myChart.setPiePosition(154, 110);
		myChart.setPieRadius(45);
		myChart.setPieUnitsColor('#555');
		myChart.draw();
	</script>
<? } ?>	