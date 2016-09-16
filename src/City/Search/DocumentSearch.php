<?php

namespace City\Search;

use \Charcoal\Search\AbstractSearch;

use \Charcoal\Translation\TranslationString;

use \Charcoal\Loader\CollectionLoader;

use \City\Object\Attachment\Document;
use \Charcoal\Attachment\Object\File;


/**
 *
 */
class DocumentSearch extends AbstractSearch
{
    /**
     * @param string $keyword The search term.
     * @return array Search results
     */
    public function search($keyword)
    {
        $document = $this->modelFactory()->get(File::class);
        $documentTable = $document->source()->table();

        $searchWord = '%'.$keyword.'%';
        $rawKeyword = $keyword;

        $arrayWord = explode(' ', $keyword);

        $q = 'SELECT document.* FROM '.$documentTable.' as document
            WHERE
                document.active = 1
            AND
                (
                    document.type = \'charcoal/attachment/object/file\'
                        OR
                    document.type = \'charcoal/attachment/object/link\'
                )
            AND
            (
                    document.title_'.$this->currentLang().' LIKE \''.$searchWord.'\'
                OR
                    document.title_'.$this->currentLang().' LIKE \''.$searchWord.'\'
                OR
                    document.keywords_'.$this->currentLang() .' LIKE \''.$searchWord.'\'
                OR
                    FIND_IN_SET(\''.$rawKeyword.'\', document.keywords_'.$this->currentLang().')
            )

            GROUP BY document.id
            ORDER BY
                CASE WHEN
                     FIND_IN_SET(\''.$rawKeyword.'\', document.keywords_'.$this->currentLang().') THEN 1
                ELSE 20
                END,
            document.title_'.$this->currentLang().' DESC
        ';

        $loader = new CollectionLoader([
            'logger' => $this->logger,
            'factory' => $this->modelFactory()
        ]);
        $loader->setModel($document);
        $loader->setDynamicTypeField('type');
        $collection = $loader->loadFromQuery($q);

        $out = ['attachments' => []];
        foreach ($collection as $c) {

            $out['attachments'][] = [
                'isFile' => $c->isFile(),
                'isLink' => $c->isLink(),
                'title' => (string)$c->title(),
                'file' => $c->file(),
                'link' => $c->link(),
                'id' => $c->id()
            ];
        }

        $this->setResults($out);
        return $out;
    }

    public function currentLang()
    {
        $translator = new TranslationString();
        return $translator->currentLanguage();
    }
}
