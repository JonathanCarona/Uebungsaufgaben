<html>
<head>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Competec Library</title>
</head>
<body>
<div id="header">

    <table style="width:100%">
        <tr>
            <td id="title">COMPETEC LIBRARY</td>
            <td>Home</td>
            <td>Books</td>
            <td>Contact</td>
            <td>FAQ</td>
        </tr>
    </table>
</div>

<div id="content">
    <div id="search">
        <form action="" method="POST">
            Author: <input type="text" name="searchAuthor">
            Book title: <input type="text" name="searchBook">
            Sort by: <select name="sort">
                <option value="author">Author</option>
                <option value="title">Title</option>
                <option value="genre">Genre</option>
                <option value="price">Price</option>
                <option value="publish_date">Publishing Date</option>
            </select>
            <input type="submit" value="Search" name="Submit">
        </form>
    </div>
    <div id="result">

        <?php
        $dom = new DOMDocument();
        $dom->load('books.xml');
        $xsl = new DOMDocument();
        $xsl->load('booksXSL.xsl');
        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $xpath = new DOMXPath($dom);


        if (isset($_POST['searchAuthor']) && $_POST['searchAuthor'] != '') {

            $bookId = array();
            $search = $_POST["searchAuthor"];
            $elements = $xpath->query("/catalog/book[author=" . "'$search'" . "]");
            /** @var DOMElement $element */
            foreach ($elements as $element) {
                $bookId[] = $element->getAttribute('id');
            }

            $bookElements = $dom->getElementsByTagName('book');
            for ($i = $bookElements->length; --$i >= 0;) {
                $book = $bookElements->item($i);
                $bookAttribute = $book->getAttribute('id');
                if (!in_array($bookAttribute, $bookId)) {
                    $book->parentNode->removeChild($book);
                }
            }
        }

        if (isset($_POST['searchBook']) && $_POST['searchBook'] != '') {

            $bookId = array();
            $search = $_POST["searchBook"];
            $elements = $xpath->query("/catalog/book[title=" . "'$search'" . "]");
            /** @var DOMElement $element */
            foreach ($elements as $element) {
                $bookId[] = $element->getAttribute('id');
            }

            $bookElements = $dom->getElementsByTagName('book');
            for ($i = $bookElements->length; --$i >= 0;) {
                $book = $bookElements->item($i);
                $bookAttribute = $book->getAttribute('id');
                if (!in_array($bookAttribute, $bookId)) {
                    $book->parentNode->removeChild($book);
                }
            }
        }
        echo $proc->transformToXml($dom);
        ?>

    </div>
</div>


</body>
</html>