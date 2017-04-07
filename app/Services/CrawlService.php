<?php
namespace App\Services;

use App\Apps;
use App\Element;
use Yangqi\Htmldom\Htmldom;

class CrawlService
{

    public function crawlCnpq()
    {
        // Initiate cURL, where the HTML document should be retrieved from the remote host. The data array sets the configurations for the post request.
        $ch = curl_init();
        $data = array('p_p_id' => 'licitacoescnpqportlet_WAR_licitacoescnpqportlet_INSTANCE_BHfsvMBDwU0V',
            'p_p_lifecycle' => '0',
            'p_p_state' => 'normal',
            'p_p_mode' => 'view',
            'p_p_col_id' => 'column - 2',
            'p_p_col_pos' => '1',
            'p_p_col_count' => '2',
            'pagina' => '1',
            'delta' => '100',
            'registros' => '100');
        $data = http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, "http://www.cnpq.br/web/guest/licitacoes");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        // On the data array, the HTML document is stored. Then we will proceed to removing unwanted information. The desired information is presented between the table tags.
        $data = trim(preg_replace('/\s\s+/', ' ', $data));

        $begin = strpos($data, '<table');
        $end = strpos($data, '</table>') + 8;

        $table = substr($data, $begin, $end - $begin);

        $html = new Htmldom($table);

        // In the origin variable, the biddings host name is set. In further versions, this can be easily upgraded and we could be able to set different biddings hosts.
        $origin = 'CNPq';

        // For each row found in the table, the desired information is extracted. For this example, as considered, we can find the information by inspection of the online table.
        foreach ($html->find('table td') as $element) {

            // Finding titles of biddings

            $begin = strpos($element, '"titLicitacao">') + 15;
            $end = strpos($element, '</h4>');
            $title = substr($element, $begin, $end - $begin);
            if ($title == "") {
                $title = 'Não consta';
            }

            // Finding objects

            $begin = strpos($element, 'cont_licitacoes">') + 17;
            $end = strpos($element, '</p></div>');
            $object = substr($element, $begin, $end - $begin);

            // Removing unnecessary tags
            $object = strip_tags($object);

            if ($object == "") {
                $object = 'Não consta';
            }

            // Finding starting date
            $begin = strpos($element, 'Abertura: <span>') + 16;
            $end = strpos($element, '</span> Publicações');
            $starting_date = substr($element, $begin, $end - $begin);

            if ($starting_date == "") {
                $starting_date = 'Não consta';
            }

            // Finding publications date
            $begin = strpos($element, 'Publicações: <span>') + 21;
            $end = strpos($element, '</span></div>');
            $publish_date = substr($element, $begin, $end - $begin);

            if ($publish_date == "") {
                $publish_date = 'Não consta';
            }

            $attachments = [];
            foreach ($element->find('a') as $link) {
                $begin = strpos($link, '</i>') + 4;
                $end = strpos($link, '</a>');
                $fileName = substr($link, $begin, $end - $begin);

                // Finding links to documents.
                $begin = strpos($link, 'href="') + 6;
                $end = strpos($link, '" target=');
                $fileDir = "http://www.cnpq.br" . substr($link, $begin, $end - $begin);

                array_push($attachments, ["Name" => $fileName, "File" => $fileDir]);
            }

            // After finding all the information needed, we create a new model to store it on the MongoDB database set locally.
            $model = new Element();
            $model->origin = $origin;
            $model->title = $title;
            $model->object = $object;
            $model->starting_date = $starting_date;
            $model->publish_date = $publish_date;
            $model->attachments = $attachments;


            $model->save();
        }
    }

}
