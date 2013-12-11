<?php echo "HELLO FROM FLIGHTS INDEX!!!"; ?>
<h2><?php echo $user->first_name; ?>'s Flight Deals</h2>

<?php for ($i=0; $i<count($descriptions); $i++) { ?>

    <h2 id="description"><?php echo $descriptions[$i]; ?></h2>

    <table>

        <tr id="header">
            <td>Destination</td>
            <td>Price ($)</td>
            <td>Airline</td>
            <td>Depart</td>
            <td>Return</td>
        </tr>

        <?php foreach($items[$i] as $content): ?>

            <tr>

                <td>
                    <?=$content['destLocation']?>
                </td>

                <td>
                    <a href=<?=$content['url']?> target="_blank" id="link"><?=$content['price']?></a>
                </td>

                <td>
                    <?=$content['airline']?>
                </td>

                <td>
                    <?=$content['departDate']?>
                </td>

                <td>
                    <?=$content['returnDate']?>
                </td>

            </tr>

        <?php endforeach; ?>
    </table>

<?php } ?>

<h5>Don't see a trip idea you were looking for?  Add a new trip idea and try again!</h5>

<!--how to get at namespace data?
http://www.sitepoint.com/simplexml-and-namespaces/
http://stackoverflow.com/questions/1186107/simple-xml-dealing-with-colons-in-nodes
http://www.sitepoint.com/parsing-xml-with-simplexml/

echo Debug::dump($items,"Results");-->