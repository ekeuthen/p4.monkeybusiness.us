<h3>Flight Deals!</h3>
<table>
    <?php foreach($items as $item): ?>

        <tr>

            <td>
                <?=$item['title']?>
            </td>

            <td>
                <?=$item['link']?>
            </td>

        </tr>

    <?php endforeach; ?>
</table>

<!--how to get at namespace data?
http://www.sitepoint.com/simplexml-and-namespaces/
http://stackoverflow.com/questions/1186107/simple-xml-dealing-with-colons-in-nodes
http://www.sitepoint.com/parsing-xml-with-simplexml/

echo Debug::dump($items,"Results");-->