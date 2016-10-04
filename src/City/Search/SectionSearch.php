<?php

namespace City\Search;

use \Charcoal\Search\AbstractSearch;

use \Charcoal\Translation\TranslationString;

use \Charcoal\Loader\CollectionLoader;

use \City\Object\Section;

/**
 *
 */
class SectionSearch extends AbstractSearch
{
    /**
     * @param string $keyword The search term.
     * @return array Search results
     */
    public function search($keyword)
    {
        $section      = $this->modelFactory()->get(Section::class);
        $sectionTable = $section->source()->table();

        $searchWord = '%'.$keyword.'%';
        $rawKeyword = $keyword;

        $arrayWord = explode(' ', $keyword);

        $q = 'SELECT section.* FROM '.$sectionTable.' as section
            LEFT JOIN
                charcoal_attachment_joins as j
            ON
                j.object_type = \'city/object/section\'
            AND
                section.id = j.object_id

            LEFT JOIN
                charcoal_attachments as attachment
            ON
                j.attachment_id = attachment.id
            WHERE
                section.active = 1
            AND
                section.title_'.$this->currentLang().' LIKE \''.$searchWord.'\'
            OR
                section.content_'.$this->currentLang().' LIKE \''.$searchWord.'\'
            OR
                FIND_IN_SET(\''.$rawKeyword.'\', section.keywords_'.$this->currentLang().')
            OR
                attachment.keywords_'.$this->currentLang().' LIKE \''.$searchWord.'\'
            OR
                attachment.keywords_'.$this->currentLang().' = \''.$rawKeyword.'\'
            OR
                attachment.title_'.$this->currentLang().' LIKE \''.$searchWord.'\'
            OR
                attachment.title_'.$this->currentLang().' = \''.$rawKeyword.'\'

            GROUP BY section.id
            ORDER BY
                CASE WHEN
                     FIND_IN_SET(\''.$rawKeyword.'\', section.keywords_'.$this->currentLang().') THEN 1
                ELSE 20
                END,
            section.title_'.$this->currentLang().' DESC
        ';

        $loader = new CollectionLoader([
            'logger'  => $this->logger,
            'factory' => $this->modelFactory()
        ]);
        $loader->setModel($section);
        $collection = $loader->loadFromQuery($q);

        $out = [];
        foreach ($collection as $c) {
            $out[] = [
                'title'         => (string)$c->title(),
                'url'           => $c->url(),
                'id'            => $c->id(),
                'description'   => substr(strip_tags((string)$c->metaDescription()), 0, 1000),
                'isExternalUrl' => $c->isExternalUrl()
            ];
        }
        $this->setResults($out);

        return $out;
    }

    /**
     * @return string
     */
    public function currentLang()
    {
        $translator = new TranslationString();

        return $translator->currentLanguage();
    }
}
