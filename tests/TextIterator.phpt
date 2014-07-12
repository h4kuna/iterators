<?php

use h4kuna\TextIterator;
use Tester\Assert;
use Tester\Environment;

# Načteme knihovny Testeru.
require __DIR__ . '/../vendor/autoload.php';          # při instalaci Composerem
# Načteme testovanou třídu. V praxi se o to zřejmě postará Composer anebo váš autoloader.
require __DIR__ . '/../TextIterator.php';



# Konfigurace prostředí velmi zpřehlední výpisy chyb.
# Nemusíte použít, pokud preferujete výchozí výpis PHP.
Environment::setup();



$text = <<<TEXT
1Lorem;ipsum;dolor sit;amet
 Lorem;ipsum;dolor sit;amet

Lorem;ipsum;dolor sit;amet
TEXT;

$textiterator = new TextIterator($text);
foreach ($textiterator as $line => $row) {
    if ($line == 0) {
        Assert::equal('1Lorem;ipsum;dolor sit;amet', $row);
    } elseif ($line == 1) {
        Assert::equal(' Lorem;ipsum;dolor sit;amet', $row);
    } elseif ($line == 2) {
        Assert::equal('', $row);
    } else {
        Assert::equal('Lorem;ipsum;dolor sit;amet', $row);
    }
}

$textiterator->setFlags(TextIterator::SKIP_EMPTY_LINE);
foreach ($textiterator as $line => $row) {
    if ($line == 0) {
        Assert::equal('1Lorem;ipsum;dolor sit;amet', $row);
    } elseif ($line == 1) {
        Assert::equal(' Lorem;ipsum;dolor sit;amet', $row);
    } else {
        Assert::equal('Lorem;ipsum;dolor sit;amet', $row);
    }
}

$textiterator->setFlags(TextIterator::SKIP_EMPTY_LINE | TextIterator::TRIM_LINE);
foreach ($textiterator as $line => $row) {
    if ($line == 0) {
        Assert::equal('1Lorem;ipsum;dolor sit;amet', $row);
    } else {
        Assert::equal('Lorem;ipsum;dolor sit;amet', $row);
    }
}

$textiterator->setCsv(';'); // TextIterator::SKIP_EMPTY_LINE | TextIterator::TRIM_LINE
foreach ($textiterator as $line => $row) {
    if ($line == 0) {
        Assert::equal(array('1Lorem', 'ipsum', 'dolor sit', 'amet'), $row);
    } else {
        Assert::equal(array('Lorem', 'ipsum', 'dolor sit', 'amet'), $row);
    }
}

$textiterator->setFlags(TextIterator::SKIP_FIRST_LINE);
$textiterator->setCsv(';');
foreach ($textiterator as $line => $row) {
    Assert::equal(array('Lorem', 'ipsum', 'dolor sit', 'amet'), $row);
}
