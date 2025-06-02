<?php
namespace App\Form;
use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class TaskType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options):void
{ $builder ->add('title', TextType::class, [
'label'=>'Titre','attr'=> ['placeholder'=>'Saisir le titre','maxlength'=>100],'constraints'
=> [new NotBlank(['message'
=>'Le Titre est obligatoire'
]),
new Length(['max'=>100,'maxMessage'=>'Le titre ne peut dépasser {{ limit }} caractères']) ] ]) 


->add('description', TextType::class, ['label'=>'Description','attr'=> ['placeholder'=>'Saisir la description','maxlength'=>1000,],'constraints'
=> [new NotBlank(['message'=>'La description est obligatoire']),new Length(['max'=>100,'maxMessage'=>'La dexcription ne peut dépasser {{ limit }} caractères']) ] ]) 


->add('status', TextType::class, ['label'=>'Description','attr'=> ['placeholder'=>'Saisir la description','maxlength'=>100, ]]);

} 
public function configureOptions(OptionsResolver $resolver):void
{ $resolver->setDefaults([
'data_class'
=> Task::class, ]); }}