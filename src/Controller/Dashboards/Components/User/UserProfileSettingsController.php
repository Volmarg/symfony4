<?php

namespace App\Controller\Dashboards\Components\User;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Url;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserSettings;
use App\Entity\User;
use App\Service\UserConfig;

class UserProfileSettingsController extends AbstractController {
    /**
     * @Route("/user/profile/settings", name="user_profile_settings")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder) {  #TODO: ask on stack
        $forms_views = $forms = [];
        $forms = $this->buildForms();

        foreach ($forms as $form_key => $form_value) {
            $forms_views[$form_key] = $form_value->createView();

            if ($request->get('form')['form-type'] != $form_key) continue;
            $this->processFormRequest($request, $form_value, $form_key, $encoder);
        }

        return $this->render('dashboards/user_profile_settings/index.html.twig', $forms_views);
    }

    protected function buildForms() {

        $user_settings = new UserSettings();
        $avatar_form = $this->createFormBuilder($user_settings)
            ->add('avatar', TextType::class, [
                'label' => 'Avatar image url',
                'constraints' => [
                    new Url([
                        'message' => 'This is not valid link!'
                    ])
                ],
                'attr' => [
                    'class' => 'form-controll',
                ]
            ])
            ->add('form-type', HiddenType::class, [
                'label' => '',
                'mapped' => false,
                'attr' => [
                    'value' => 'avatar_form',

                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Change avatar', 'attr' => [
                    'class' => 'btn btn-lg btn-primary btn-block'
                ]
            ])
            ->getForm();

        $login_data_form = $this->createFormBuilder($this->getUser())
            ->add('uuid', TextType::class, [
                'label' => 'New Login',
                'constraints' => [
                    new NotBlank([
                        'message' => 'User name cannot be blank'
                    ])
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'New password',
                'constraints' => [
                    new NotBlank([
                        'message' => 'User password cannot be blank',
                    ]),
                    new Length([
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('form-type', HiddenType::class, [
                'label' => '',
                'mapped' => false,
                'attr' => [
                    'value' => 'login_data_form',

                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Change settings', 'attr' => [
                    'class' => 'btn btn-lg btn-primary btn-block'
                ]
            ])
            ->getForm();

        return compact('avatar_form', 'login_data_form');
    }

    protected function processFormRequest($request, $form_value, $form_key, $encoder) {
        $form_value->handleRequest($request);

        if ($form_value->isSubmitted() && $form_value->isValid()) {
            if ($form_key == 'login_data_form') {
                $this->updateUserLoginCredentials($request->get('form'), $encoder);
            } elseif ($form_key == 'avatar_form') {
                $this->updateUserAvatar($request->get('form')['avatar']);
            }
        }
    }

    protected function updateUserAvatar($avatar) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $query_result = $qb->select(array('us'))
            ->from('App:UserSettings', 'us')
            ->where('us.user_id_id = ' . $user->getId())
            ->getQuery()
            ->getResult();

        $user_config = $query_result[0];
        $user_config->setAvatar($avatar);
        $em->persist($user_config);
        $em->flush();
        return;
    }

    protected function updateUserLoginCredentials($form, $encoder) {

        $em = $this->getDoctrine()->getManager();
        $user_entity = $em->getRepository(User::class)->find($this->getUser()->getId());

        $user_entity->setPassword($encoder->encodePassword($user_entity, $form['password']));
        $user_entity->setUuid($form['uuid']);

        $em->persist($user_entity);
        $em->flush();
    }

}
