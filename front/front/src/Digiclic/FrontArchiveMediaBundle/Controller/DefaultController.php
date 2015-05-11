<?php

namespace Digiclic\FrontArchiveMediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this->get('clients_service')->getCategories();
        if ($categories==null) {
            $categories = array();
        }
        $images = 
        array(
            'TV'=>'http://archives-media.com/wp-content/medias/2015/04/PICTO-PROGRAMME-TV.png',
            'MUSIQUE'=>'http://archives-media.com/wp-content/medias/2015/04/PICTO-MUSIQUE.png',
            'CLAP'=>'http://archives-media.com/wp-content/medias/2015/04/PICTO-FILM.png',
            'PEOPLE'=>'http://archives-media.com/wp-content/medias/2015/04/PICTO-PROGRAMME-TV.png',
            'PHOTO'=>'http://archives-media.com/wp-content/medias/2015/05/PICTO-DIAPO-e1430827925314.jpg',
            'PERSO'=>'http://archives-media.com/wp-content/medias/2015/04/PICTO-INTERVIEW.png',
            'BANDE'=>'http://archives-media.com/wp-content/medias/2015/04/PICTO-DOCUMENTAIRE.png'
        );
        foreach ($categories as &$category) {
            $category['image'] = isset($images[$category['logo']]) ? $images[$category['logo']] : $images['BANDE'];
        }
        return array('categories' => $categories);
    }

    /**
     * @Route("/check", name="security_check")
     */
    public function securityCheck()
    {
    }

    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        return array();
    }

    /**
     * @Route("/category/{category}", name="category")
     * @Template()
     */
    public function categoryAction($category)
    {
        $categories = $this->get('clients_service')->getCategories();
        if ($categories==null) {
            $categories = array();
        }

        $category_object = $this->get('clients_service')->getCategory($category);
        $videos = $this->get('clients_service')->getVideosForCategory($category);
        return array('videos'=>$videos, 'category'=>$category_object, 'categories'=>$categories);
    }

    /**
     * @Route("/video/{video}", name="video")
     * @Template()
     */
    public function videoAction($video)
    {
        $categories = $this->get('clients_service')->getCategories();
        if ($categories==null) {
            $categories = array();
        }
        $video = $this->get('clients_service')->getVideo($video);
        return array('video'=>$video, 'categories'=>$categories);
    }

}
