<?php

class Hatimeria_Weblog_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction()
    {
        //żeby wrzucić to do modelu jak w Hatimeria_News_Model_Post trzeba zrobić templatkę i wywołać w niej funkcję
        $params = $this->getRequest()->getParams();
        $blogpost = Mage::getModel('hweblog/blogpost');
        echo 'Loading the blogpost with an ID of ' . $params['id'];
        $blogpost->load($params['id']);
        $data = $blogpost->getData('title');
        $title = $blogpost->getTitle();
        Zend_Debug::dump(get_class($blogpost));
        Zend_Debug::dump($data);
        Zend_Debug::dump($title);
    }

    public function createNewAction()
    {
        $blogpost = Mage::getModel('hweblog/blogpost');
        $blogpost->setTitle('Code Post!');
        $blogpost->setPost('This post was created from code!');
        $blogpost->save();
        echo 'post with ID ' . $blogpost->getId() . ' created';
    }

    public function editFirstPostAction() {
        $blogpost = Mage::getModel('hweblog/blogpost');
        $blogpost->load(1);
        $blogpost->setTitle("The First post!");
        $blogpost->save();
        echo 'post edited';
    }

    public function deleteFirstPostAction() {
        $blogpost = Mage::getModel('hweblog/blogpost');
        $blogpost->load(1);
        $blogpost->delete();
        echo 'post removed';
    }

    public function showAllBlogPostsAction() {
        $posts = Mage::getModel('hweblog/blogpost')->getCollection();
        foreach($posts as $blogpost){
            echo '<h3>'.$blogpost->getTitle().'</h3>';
            echo nl2br($blogpost->getPost());
        }
    }

}