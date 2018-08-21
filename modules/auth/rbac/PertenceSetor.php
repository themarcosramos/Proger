<?php
namespace app\rbac;

use yii\rbac\Rule;

/**
* Verifica se o authorID corresponde ao usuário passado via  parâmetro
*/
class PertenceSetorRule extends Rule
{
   public $name = 'isAuthor';

   /**
    * @param string|int $user the user ID.
    * @param Item $item the role or permission that this rule is associated with
    * @param array $params parameters passed to ManagerInterface::checkAccess().
    * @return bool a value indicating whether the rule permits the role or permission it is associated with.
    */
   public function execute($user, $item, $params)
   {
       return isset($params['post']) ? $params['post']->createdBy == $user : false;
   }
}


?>