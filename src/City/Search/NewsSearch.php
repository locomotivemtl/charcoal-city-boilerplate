<?php

namespace City\Search;

use \Charcoal\Search\AbstractSearch;

use \Charcoal\Translation\TranslationString;

use \Charcoal\Loader\CollectionLoader;

use \City\Object\News;

/**
 *
 */
class NewsSearch extends AbstractSearch
{
    /**
     * @param string $keyword The search term.
     * @return array Search results
     */
    public function search($keyword)
    {
        $news = $this->modelFactory()->get(News::class);
        $newsTable = $news->source()->table();


        $searchWord = '%'.$keyword.'%';
        $rawKeyword = $keyword;

        $arrayWord = explode(' ', $keyword);

        $q = 'SELECT news.* FROM '.$newsTable.' as news
            LEFT JOIN
                charcoal_attachment_joins as j
            ON
                j.object_type = \'city/object/news\'
            AND
                news.id = j.object_id

            LEFT JOIN
                charcoal_attachments as attachment
            ON
                j.attachment_id = attachment.id
            WHERE
                news.active = 1
            AND
                news.title_'.$this->currentLang().' LIKE \''.$searchWord.'\'
            OR
                news.subtitle_'.$this->currentLang() .' LIKE \''.$searchWord.'\'
            OR
                news.content_'.$this->currentLang() .' LIKE \''.$searchWord.'\'
            OR
                attachment.keywords_'.$this->currentLang().' LIKE \''.$searchWord.'\'
            OR
                attachment.keywords_'.$this->currentLang().' = \''.$rawKeyword.'\'
            OR
                attachment.title_'.$this->currentLang().' LIKE \''.$searchWord.'\'
            OR
                attachment.title_'.$this->currentLang().' = \''.$rawKeyword.'\'

            GROUP BY news.id
            ORDER BY
                CASE WHEN
                     news.title_'.$this->currentLang().' LIKE \''.$searchWord.'\' THEN 1
                ELSE 20
                END,
            news.title_'.$this->currentLang().' DESC
        ';

        $loader = new CollectionLoader([
            'logger' => $this->logger,
            'factory' => $this->modelFactory()
        ]);
        $loader->setModel($news);
        $collection = $loader->loadFromQuery($q);

        $out = [];
        foreach ($collection as $c) {
            $out[] = [
                'title' => (string)$c->title(),
                'url' => $c->url(),
                'id' => $c->id(),
                'displayDate' => $c->displayDate(),
                'categoryName' => $c->categoryName(),
                'description' => strip_tags((string)$c->metaDescription())
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
