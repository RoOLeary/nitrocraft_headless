<?php 

namespace config\endpoints;

use craft\elements\Entry;
use craft\helpers\UrlHelper; 


class Homepage {
    public static function view($slug)
    {
        return [
            'elementType' => Entry::class,
            'criteria' => ['section' => 'homepage'],
            'transformer' => function(Entry $entry) {

                $bodyBlocks = [];
                foreach ($entry->pageBlocks->all() as $block) {
                    switch ($block->type->handle) {
                        case 'hero':
                            $bodyBlocks[] = [
                                'uid' => $block->uid,
                                'blockType' => 'hero',
                                'eyebrow' => $block->eyebrow,
                                'heading' => $block->heading,
                                'subHeadline' => $block->subHeadline
                            ];
                            break;
                            case 'header':
                            $bodyBlocks[] = [
                                'uid' => $block->uid,
                                'blockType' => 'header',
                                'headline' => $block->headline,
                            ];
                            break;
                        case 'faq':
                            $faqRows = [];
                            foreach($block->faqs->all() as $row){
                                $faqRows[] = [
                                    'question' => $row->question,
                                    'answer' => $row->answer,
                                ];
                            }
                            $bodyBlocks[] = [
                                'uid' => $block->uid,
                                'blockType' => 'faq',
                                'faqHeading' => $block->faqHeading,
                                'faqLeadtext' => $block->faqLeadtext,
                                'faqs' => $faqRows
                            ];
                            break;
                        
                        // case 'speakers':
                        //     // $selectedSpeakers = [];
                        //     $relatedCat = $block->speakerCategory->one()->id;
                            
                        //     // $blockSpeakers = Entry::find()
                        //     //     ->section('speakers')
                        //     //     ->relatedTo($relatedCat)
                        //     //     ->limit(10)
                        //     //     ->all();

                            
                        //     // $selectedSpeakers = [];
                        //     //     foreach($blockSpeakers as $spkr){
                        //     //     $selectedSpeakers[] = [
                        //     //         'speakerName' => $spkr->speakerName
                        //     //     ];
                        //     // }

                        //     $bodyBlocks[] = [
                        //         'heading' => $block->heading,
                        //         'speakersIntro' => $block->speakersIntro,
                        //         // 'speakers' => $selectedSpeakers
                        //     ];
                        //     break;
                        case 'video':
                            $bodyBlocks[] = [
                                'uid' => $block->uid,
                                'blockType' => 'video',
                                'videoTitle' => $block->videoTitle,
                                'videoEmbedCode' => $block->videoEmbedCode,
                            ];
                            break;
                        case 'imageSlider':
                            $SuperTableRows = [];
                            foreach ($block->sliderMatrix->all() as $row){
                                $SuperTableRows[] = [
                                    'textSub' => $row->textSub,
                                    'textHeading' => $row->textHeading,
                                    'textBackground' => $row->textBackground,
                                    'slideImage' => $row->slideImage,
                                    'slideColor' => $row->slideColor->value,
                                ];
                            }
                            $bodyBlocks[] = [
                                'uid' => $block->uid,
                                'blockType' => 'imageSlider',
                                'sliderTitle' => $block->sliderTitle,
                                'sliderMatrix' => $SuperTableRows,
                            ];
                            break;
                        case 'text':
                            $bodyBlocks[] = [
                                'uid' => $block->uid,
                                'blockType' => 'text',
                                'headline' => $block->headline,
                                'articleBody' => $block->articleBody,
                            ];
                            break;
                        case 'textVisual':

                            $TVButtons = [];
                            foreach ($block->textVisualButtons->all() as $row){
                                $TVButtons[] = [
                                    'linkId' => $row->linkId,
                                    'linkText' => $row->linkText,
                                    'linkUrl' => $row->linkUrl,
                                    'isExternal' => $row->target
                                ];
                            }

                            $bodyBlocks[] = [
                                'uid' => $block->uid,
                                'blockType' => 'textVisual',
                                'title' => $block->textVisualTitle,
                                'articleBody' => $block->textVisualContent,
                                'image' => $block->textVisualImage,
                                'buttons' => $TVButtons,
                            ];
                            break;
                    }
                }

                return [
                    'title' => $entry->title,
                    // 'homeIntro' => $entry->homeIntro,
                    'blocks' => $bodyBlocks,
                    'jsonUrl' => UrlHelper::url("api/homepage.json"),
                ];
            },
        ];
    }   
}