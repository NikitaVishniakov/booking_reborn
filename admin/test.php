<?php include("header.php");
//    prolongationOptions()dcs
$graph = array(
  'A' => array('B' => 3, 'D' => 3, 'F' => 6),
  'B' => array('A' => 3, 'D' => 1, 'E' => 3),
  'C' => array('E' => 2, 'F' => 3),
  'D' => array('A' => 3, 'B' => 1, 'E' => 1, 'F' => 2),
  'E' => array('B' => 3, 'C' => 2, 'D' => 1, 'F' => 5),
  'F' => array('A' => 6, 'C' => 3, 'D' => 2, 'E' => 5),
);

function shortestWay($start, $destination, $graph) {
    $shortest = [];
    $previous = [];
    $not_visited = new SplPriorityQueue();

    foreach ($graph as $vertex => $ways):
        $previous[$vertex] = null;
        $shortest[$vertex] = INF;
        foreach ($ways as $vertex_dest => $weight):
            $not_visited->insert($vertex_dest, $weight);
        endforeach;
    endforeach; 
    
    $shortest[$start] = 0;
    
    while (!$not_visited->isEmpty()):
        $min = $not_visited->extract();
        if(!empty($graph[$min])):
            foreach($graph[$min] as $vertex_dest => $weight):
                $new_weight = $shortest[$min] + $weight;
                if($new_weight < $shortest[$vertex_dest]):
                    $shortest[$vertex_dest] = $new_weight;
                    $previous[$vertex_dest] = $min;
                endif;
            endforeach;
        endif;
    endwhile;
    
    $stack = new SplStack();
    $distance = 0;
    $dest = $destination;
    
    while(isset($previous[$dest])):
        $stack->push($dest);
        $distance += $graph[$dest][$previous[$dest]];
        $dest = $previous[$dest];
    endwhile;
    
    if($stack->isEmpty()):
        return "Невозможно проложить путь из узла $start в узел $destination :(";
    else:
        $stack->push($start);
        $msg = "Длина пути из узла $start в узел $destination равна $distance. ";
    
        if($stack->count() == 2):
            $msg .= "Промежуточные узлы отсутствуют.";
        else:
            $msg .= "Путь с промежуточными узлами: ";
            for($i = 0; $i <$stack->count(); $i++):
                $separator = '<span class="red"> → </span>';
                if ($i + 1 == $stack->count()):
                    $separator = '';
                endif;
    
                if ($i == $stack->count() - 1):
                    $short_dist = '';
                else:
                    $short_dist = "(".$graph[$stack[$i]][$stack[$i+1]].")";
                endif;
                $msg .= "$stack[$i] $short_dist $separator";
            endfor;
        endif;    
    endif;
    return $msg;
}
$text = '';
if(isset($_POST['submit'])){
    $start = trim(strtoupper($_POST['start']));
    $dest = trim(strtoupper($_POST['dest']));
    $text = shortestWay($start, $dest, $graph);
}

?>
<style>
    .modal-dialog{
        text-align: center;
    }
    pre {
        width: 500px;
        padding-right: 60px;
        margin: auto;
        text-align: center;
    }
</style>

<div class="modal-dialog">
    <h2 class="center">Алгоритм Дейкстры</h2>
    <p>C использованием стека в качестве временного хранилища.</p>
    <form action="#" method="Post">
        <input type="text" class="form-control" name="start" placeholder="Начало">
        <input type="text" class="form-control" name="dest" placeholder="Конец">
        <input type="submit" class="btn btn-success" name="submit" value="Расчитать">
    </form>
    <div class="graf-distance">
        <p><?php echo $text; ?></p>
    </div>
</div>
<h2 class="text-center">Стурктура графа:</h2>
<pre>
    <?php print_r($graph); ?>
</pre>
<?php
    include("footer.php");
?>
