<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication\Doctrine\Fixture;

use App\Domain\Authentication\Enum\LanguageEnum;
use App\Domain\Authentication\Enum\RoleEnum;
use App\Domain\Authentication\Enum\StatusEnum;
use App\Domain\Authentication\Model\Embedded\Token;
use App\Domain\Authentication\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $item) {
            if (empty($item['email'])) {
                dd($item);
            }
            $user = new User();
            $user
                ->setUsername($item['email'])
                ->setUuid($item['uuid'])
                ->setPlainPassword($item['password'])
                ->setLocale($item['locale'])
            ;

            if (!empty($item['roles'])) {
                $user->setRoles($item['roles']);
            }

            if (!empty($item['status'])) {
                $user->setStatus($item['status']);
            }

            if (!empty($item['token'])) {
                $token = new Token();
                $token
                    ->setValue($item['token']['value'])
                    ->setExpiredAt(new \DateTime($item['token']['expiredAt']))
                ;
                $user->setToken($token);
            }

            if (!empty($item['dateDeleted'])) {
                $user->setDateDeleted($item['dateDeleted']);
            }

            if (!empty($item['deletedBy'])) {
                $user->setDeletedBy($item['deletedBy']);
            }

            $this->encodePassword($user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function encodePassword(User $user)
    {
        if (null !== $user->getPlainPassword()) {
            $user
                ->setPassword($this->encoder->hashPassword($user, $user->getPlainPassword()))
                ->setPlainPassword(null)
            ;
        }
    }

    private function getData(): array
    {
        return [
            [
                'familyName' => 'Doe',
                'givenName' => 'John',
                'email' => 'john.doe@altezis.com',
                'uuid' => '97cb8841-b718-4720-b90a-122943dfd629',
                'roles' => [RoleEnum::SUPER_ADMIN],
                'locale' => LanguageEnum::FR,
                'password' => '1234',
            ],
            [
                'familyName' => 'Doe',
                'givenName' => 'Jane',
                'email' => 'jane.doe@altezis.com',
                'uuid' => '1df87bac-46da-45a1-8eab-5c876ac5aa92',
                'roles' => [RoleEnum::ADMIN],
                'locale' => LanguageEnum::FR,
                'password' => '4321',
            ],

            [
                'familyName' => 'Besson',
                'givenName' => 'Virginie',
                'email' => 'delahaye.emmanuelle@live.com',
                'uuid' => '5de2aa9e-de6a-4ccf-b7f8-b19d65ea0b1b',
                'locale' => LanguageEnum::FR,
                'password' => 'v=`YhC:Myb2xc#PEr',
                'status' => [
                    StatusEnum::EMAIL_PENDING_VALIDATION_STATUS => 1,
                    StatusEnum::PASSWORD_VALID_STATUS => 1,
                    StatusEnum::UNBLOCKED_STATUS => 1,
                ],
                'token' => [
                    'value' => 'e3c77164-074c-415c-905c-eed6e172ff97',
                    'expiredAt' => '+1 hour',
                ],
            ],
            [
                'familyName' => 'Guichard',
                'givenName' => 'Françoise',
                'email' => 'qherve@free.fr',
                'uuid' => '573e8c2c-49c1-4dbe-a455-1e5f1d6da104',
                'locale' => LanguageEnum::FR,
                'password' => 'v2dvCm27YYB5',
                'status' => [
                    StatusEnum::EMAIL_PENDING_VALIDATION_STATUS => 1,
                    StatusEnum::PASSWORD_VALID_STATUS => 1,
                    StatusEnum::UNBLOCKED_STATUS => 1,
                ],
                'token' => [
                    'value' => 'a39d47e7-6716-4e3e-92c3-442c50f360ed',
                    'expiredAt' => '-1 hour',
                ],
            ],
            [
                'familyName' => 'Auger',
                'givenName' => 'Chantal',
                'email' => 'laure.neveu@noos.fr',
                'uuid' => '999c1136-cc25-4c64-90a7-f604467c1afe',
                'locale' => LanguageEnum::FR,
                'password' => 'QBcVDw<I]2FVu-BE&SvS',
                'status' => [
                    StatusEnum::EMAIL_VALID_STATUS => 1,
                    StatusEnum::WAITING_PASSWORD_CHANGE_STATUS => 1,
                    StatusEnum::UNBLOCKED_STATUS => 1,
                ],
                'token' => [
                    'value' => '1af7ef0b-7a60-4264-a68a-7c5dbe92e588',
                    'expiredAt' => '+1 hour',
                ],
            ],
            [
                'familyName' => 'Legrand',
                'givenName' => 'Charlotte',
                'email' => 'qduhamel@free.fr',
                'uuid' => '78783cfa-082c-4930-91ca-0215e30cef2d',
                'locale' => LanguageEnum::FR,
                'password' => ')jA)d-j@lOhAmam9',
                'status' => [
                    StatusEnum::EMAIL_VALID_STATUS => 1,
                    StatusEnum::WAITING_PASSWORD_CHANGE_STATUS => 1,
                    StatusEnum::UNBLOCKED_STATUS => 1,
                ],
                'token' => [
                    'value' => '8a589208-4267-4452-8a6e-f750c4c99ae8',
                    'expiredAt' => '-1 hour',
                ],
            ],
            [
                'familyName' => 'Chauvet',
                'givenName' => 'Pauline',
                'email' => 'nlefebvre@sfr.fr',
                'uuid' => '3060dacb-d5e0-4330-9fe8-9d9c4d02603c',
                'locale' => LanguageEnum::FR,
                'password' => 'aA[=8_3qU-%#{J&/vx',
                'token' => [
                    'value' => '21dd77fc-b615-4a6c-b4a0-91317ececcc7',
                    'expiredAt' => '+1 hour',
                ],
            ],
            [
                'familyName' => 'Brun',
                'givenName' => 'Édith',
                'email' => 'alphonse.vaillant@tele2.fr',
                'uuid' => 'c9cfb514-4713-4cd0-8848-cea377a66172',
                'locale' => LanguageEnum::FR,
                'password' => 'T`Wlg5T8v>&3Q;UX?U',
                'status' => [
                    StatusEnum::EMAIL_VALID_STATUS => 1,
                    StatusEnum::PASSWORD_VALID_STATUS => 1,
                    StatusEnum::BLOCKED_STATUS => 1,
                ],
            ],
            [
                'familyName' => 'Gay',
                'givenName' => 'François',
                'email' => 'tristan.olivier@tele2.fr',
                'uuid' => 'd3cfc65a-7d10-4ba4-bee7-3b082200b901',
                'locale' => LanguageEnum::FR,
                'password' => '2?mC<DD&oOJ-F@e;A~,',
                'dateDeleted' => new \DateTime('2022-01-05'),
                'deletedBy' => 'john.doe@altezis.fr',
            ],
            [
                'familyName' => 'Daniel',
                'givenName' => 'Thierry',
                'email' => 'xparis@tele2.fr',
                'uuid' => '65e7becd-6385-40f4-9b2b-4a53a24a5c91',
                'locale' => LanguageEnum::FR,
                'password' => '_&>pi^/Ku=#=}(CtQ',
            ],
            [
                'familyName' => 'Francois',
                'givenName' => 'Claude',
                'email' => 'mcoulon@free.fr',
                'uuid' => '4af9cc1d-9e79-4c05-ad26-3021e368a1c0',
                'locale' => LanguageEnum::FR,
                'password' => 'JeLF4ovpd1tG5n7',
            ],
            [
                'familyName' => 'Gomez',
                'givenName' => 'Édouard',
                'email' => 'qollivier@hotmail.fr',
                'uuid' => '81936289-aa60-4897-ab9e-9f7114964dd4',
                'locale' => LanguageEnum::FR,
                'password' => '#%T#e1\H0ZJ[rc[\0',
            ],
            [
                'familyName' => 'Morin',
                'givenName' => 'Robert',
                'email' => 'cdiaz@free.fr',
                'uuid' => '429d5e97-4d63-4076-a4d3-cc9d6b5e8752',
                'locale' => LanguageEnum::FR,
                'password' => 'Lg@VdB+vy&AY3N}',
            ],
            [
                'familyName' => 'Marchal',
                'givenName' => 'Alfred',
                'email' => 'zbouvet@yahoo.fr',
                'uuid' => 'e812221a-3d90-4011-be53-72cb3c1b000d',
                'locale' => LanguageEnum::FR,
                'password' => 'x[2{v/>Pzu;",,@',
            ],
            [
                'familyName' => 'Hamon',
                'givenName' => 'Martine',
                'email' => 'honore47@laposte.net',
                'uuid' => '26489c20-a150-43b8-a594-9ba659ac966d',
                'locale' => LanguageEnum::FR,
                'password' => 'opf?14SRX-@fW6MUx_&',
            ],
            [
                'familyName' => 'Julien',
                'givenName' => 'Bernard',
                'email' => 'pmarin@wanadoo.fr',
                'uuid' => 'f4c86887-9498-4cba-941c-89884daf807d',
                'locale' => LanguageEnum::FR,
                'password' => 'LYdZPm-k]jmoXP^}',
            ],
            [
                'familyName' => 'Petitjean',
                'givenName' => 'Anouk',
                'email' => 'allard.bernard@laposte.net',
                'uuid' => 'd2f4b34e-b8fe-4cf6-8063-71780ccd556c',
                'locale' => LanguageEnum::FR,
                'password' => '4^Zoscnypi)>nrC',
            ],
            [
                'familyName' => 'Colas',
                'givenName' => 'André',
                'email' => 'achevalier@free.fr',
                'uuid' => '7803ebbf-bb06-475e-856e-df36cdfb4e0a',
                'locale' => LanguageEnum::FR,
                'password' => '%"n~-8?4\k`gPSS[',
            ],
            [
                'familyName' => 'Francois',
                'givenName' => 'Richard',
                'email' => 'charles.lacombe@tele2.fr',
                'uuid' => '0fbd069f-3b5c-4d9b-b122-2f49729554b3',
                'locale' => LanguageEnum::FR,
                'password' => 'i:#t).p_K\s%J3Q[',
            ],
            [
                'familyName' => 'Delannoy',
                'givenName' => 'Eugène',
                'email' => 'vblanchard@club-internet.fr',
                'uuid' => '7a18b0ba-cd4d-4563-b512-163712528107',
                'locale' => LanguageEnum::FR,
                'password' => 'uMl&rdGH7Gv={IRS',
            ],
            [
                'familyName' => 'Tanguy',
                'givenName' => 'Stéphanie',
                'email' => 'fdiallo@yahoo.fr',
                'uuid' => '3c64b8a1-e86c-4b79-a107-734f69e87e91',
                'locale' => LanguageEnum::FR,
                'password' => '#a</Y)X?R("P.:"&Dw',
            ],
            [
                'familyName' => 'Joseph',
                'givenName' => 'Joseph',
                'email' => 'eric17@club-internet.fr',
                'uuid' => '3e1ca420-937d-4ab8-bc9c-36fc895019d0',
                'locale' => LanguageEnum::FR,
                'password' => 'QF]Du2g~G#)y!k',
            ],
            [
                'familyName' => 'Schneider',
                'givenName' => 'Eugène',
                'email' => 'margaux20@noos.fr',
                'uuid' => 'e058e4ca-23f3-4293-b6f9-0afb0005eb05',
                'locale' => LanguageEnum::FR,
                'password' => 'bnt&JdQF/DX{kcB(ji#M',
            ],
            [
                'familyName' => 'Albert',
                'givenName' => 'Paul',
                'email' => 'ubarbe@dbmail.com',
                'uuid' => '4d1e8939-eb8a-4848-9236-7bc924b90404',
                'locale' => LanguageEnum::FR,
                'password' => '.rk/JQ]T`:,znYyhUM',
            ],
            [
                'familyName' => 'Lejeune',
                'givenName' => 'Daniel',
                'email' => 'lefebvre.paul@live.com',
                'uuid' => '05a0bc9a-c7fd-4fae-b11a-7612b018ac44',
                'locale' => LanguageEnum::FR,
                'password' => 'eHcahL@EQCio#^)F',
            ],
            [
                'familyName' => 'Laroche',
                'givenName' => 'Hugues',
                'email' => 'tanguy.penelope@laposte.net',
                'uuid' => '92467f7b-073c-4316-b477-89901d9fee0e',
                'locale' => LanguageEnum::FR,
                'password' => '2Qx!2`Ts-MPnuP',
            ],
            [
                'familyName' => 'Duhamel',
                'givenName' => 'Christelle',
                'email' => 'anastasie24@dbmail.com',
                'uuid' => '006033e2-0ed8-4078-934a-1b453df13021',
                'locale' => LanguageEnum::FR,
                'password' => '1n&9=SAFaM9%1e]"&$Q',
            ],
            [
                'familyName' => 'Chretien',
                'givenName' => 'Henri',
                'email' => 'william.jacques@wanadoo.fr',
                'uuid' => '429a344e-6418-4d16-be74-4968626297c0',
                'locale' => LanguageEnum::FR,
                'password' => ',hAYtZf#y1ob5T*^>MWW',
            ],
            [
                'familyName' => 'Prevost',
                'givenName' => 'Théodore',
                'email' => 'agathe34@orange.fr',
                'uuid' => 'fc46ea27-aa03-425d-921b-9a371aa42c12',
                'locale' => LanguageEnum::FR,
                'password' => 'jRF3.62kayb^\Uiu0Dh',
            ],
            [
                'familyName' => 'Marchal',
                'givenName' => 'Jean',
                'email' => 'girard.lucas@tele2.fr',
                'uuid' => '5c49a46a-e566-40cf-9b01-d53606a12795',
                'locale' => LanguageEnum::FR,
                'password' => '0MgSJT)s"HtJ&F?X',
            ],
            [
                'familyName' => 'Brunet',
                'givenName' => 'Grégoire',
                'email' => 'sanchez.noel@tele2.fr',
                'uuid' => 'f65a8a11-b018-41f4-bc2c-142b77ad3afe',
                'locale' => LanguageEnum::FR,
                'password' => '7[*`.p-Bxub*{vvy0:QE',
            ],
            [
                'familyName' => 'Lemonnier',
                'givenName' => 'Alexandria',
                'email' => 'coste.gilbert@dbmail.com',
                'uuid' => 'dd2198af-6678-431d-9dd4-6f5c096eefee',
                'locale' => LanguageEnum::FR,
                'password' => 'Ge=nHyi?GpWDm4T$~H',
            ],
            [
                'familyName' => 'Bonneau',
                'givenName' => 'Margaret',
                'email' => 'fmorvan@gmail.com',
                'uuid' => 'd10823d0-9f77-424e-93b9-fb982ecabc8f',
                'locale' => LanguageEnum::FR,
                'password' => 'Hk)pnbaVe=>|~hH.',
            ],
            [
                'familyName' => 'Seguin',
                'givenName' => 'Matthieu',
                'uuid' => '5ab061d2-2733-44df-a9ef-16b600ad4a7e',
                'email' => 'oneveu@club-internet.fr',
                'locale' => LanguageEnum::FR,
                'password' => 'kmx*e;CsQ{~~2>A',
            ],
            [
                'familyName' => 'Riou',
                'givenName' => 'William',
                'email' => 'celine.bousquet@wanadoo.fr',
                'uuid' => '96e7c8a8-1a2d-4afe-9b7b-bc9429e16a5d',
                'locale' => LanguageEnum::FR,
                'password' => 'Tlp6:t<wCvjz2]0',
            ],
            [
                'familyName' => 'Goncalves',
                'givenName' => 'Matthieu',
                'email' => 'blanchet.charles@hotmail.fr',
                'uuid' => 'ecc0ef87-b852-4199-baf5-5007ae46d808',
                'locale' => LanguageEnum::FR,
                'password' => 'eg%8"FX@x*]SD?jhK%',
            ],
            [
                'familyName' => 'Barthelemy',
                'givenName' => 'Olivier',
                'email' => 'weber.adrien@gmail.com',
                'uuid' => '94424944-7ae3-460a-903c-8a60c046ca9c',
                'locale' => LanguageEnum::FR,
                'password' => '}g(8OT[~MUgG$EqKbt',
            ],
            [
                'familyName' => 'Marin',
                'givenName' => 'Anaïs',
                'email' => 'oimbert@laposte.net',
                'uuid' => '7593c0f6-3344-4fb9-8458-8367b82ca1fa',
                'locale' => LanguageEnum::FR,
                'password' => '&>1(J<nY(TO&.0+',
            ],
            [
                'familyName' => 'Costa',
                'givenName' => 'Alexandrie',
                'email' => 'bernard.millet@hotmail.fr',
                'uuid' => '00e78fdd-258e-4b7c-be8a-184ae4932460',
                'locale' => LanguageEnum::FR,
                'password' => '#q>YpZSFp}vZ#iW',
            ],
            [
                'familyName' => 'Guibert',
                'givenName' => 'Robert',
                'email' => 'mallet.virginie@sfr.fr',
                'uuid' => '462d8af0-786d-484e-8d93-f50f632861e5',
                'locale' => LanguageEnum::FR,
                'password' => 'c0mn1f?lVw\a~XqlI3t',
            ],
            [
                'familyName' => 'Letellier',
                'givenName' => 'Océane',
                'email' => 'techer.valentine@sfr.fr',
                'uuid' => 'ad991205-d333-442c-85e0-ae2c9dbd4bd9',
                'locale' => LanguageEnum::FR,
                'password' => '+<5w1`;1hZCH05ey-)7',
            ],
            [
                'familyName' => 'Lenoir',
                'givenName' => 'Océane',
                'email' => 'albert.capucine@free.fr',
                'uuid' => 'fc0fa727-7971-4e24-bbc6-e4d06046d107',
                'locale' => LanguageEnum::FR,
                'password' => 'm"aM%^m%FJ"?]95PP',
            ],
            [
                'familyName' => 'Charpentier',
                'givenName' => 'Élodie',
                'email' => 'wbruneau@yahoo.fr',
                'uuid' => 'e3194845-4e40-45d5-aca2-62f1b3a8d757',
                'locale' => LanguageEnum::FR,
                'password' => ',8L!YOQ2:[j}_E;<YF`4',
            ],
            [
                'familyName' => 'Costa',
                'givenName' => 'Agnès',
                'email' => 'louis.diallo@gmail.com',
                'uuid' => '559c46fc-bc6f-4bbd-86a4-4bc5a9f39a43',
                'locale' => LanguageEnum::FR,
                'password' => '{3mO=HBA$mcm7CKAjW<',
            ],
            [
                'familyName' => 'Legros',
                'givenName' => 'Véronique',
                'email' => 'ramos.gabrielle@noos.fr',
                'uuid' => '1d018396-3ea1-451b-8c32-e31ae10b062d',
                'locale' => LanguageEnum::FR,
                'password' => '($AHP/Ovx$s\qVgc"&a',
            ],
            [
                'familyName' => 'Gerard',
                'givenName' => 'Marc',
                'email' => 'stephanie25@wanadoo.fr',
                'uuid' => 'aa659c88-2386-4c7e-9a2a-8865e33888d6',
                'locale' => LanguageEnum::FR,
                'password' => 'U:5bi8]%C,|Ow)P',
            ],
            [
                'familyName' => 'Joubert',
                'givenName' => 'Pierre',
                'email' => 'letellier.tristan@tele2.fr',
                'uuid' => 'bef7968e-ccd3-446d-8bf5-3d8136596f3c',
                'locale' => LanguageEnum::FR,
                'password' => 'T(t_D|pBFI>tb<39!',
            ],
            [
                'familyName' => 'Benard',
                'givenName' => 'Adrien',
                'email' => 'qbourgeois@hotmail.fr',
                'uuid' => 'de0a992e-fa4f-4201-b7bf-cd5bd6e53d91',
                'locale' => LanguageEnum::FR,
                'password' => 'Ph&Tz-.W=/b4?6GI;',
            ],
            [
                'familyName' => 'Bailly',
                'givenName' => 'Maggie',
                'email' => 'audrey.jacob@sfr.fr',
                'uuid' => '3f12ea53-6e57-4dc3-a7af-7cd4536eeeab',
                'locale' => LanguageEnum::FR,
                'password' => 'OsLK(m,1{?y2&bN',
            ],
            [
                'familyName' => 'Hernandez',
                'givenName' => 'Jacqueline',
                'email' => 'elodie20@free.fr',
                'uuid' => 'b6a6fa62-421d-4001-968f-ee4dadc58666',
                'locale' => LanguageEnum::FR,
                'password' => '4T_g)WRYh|jG\6?f&!{"',
            ],
            [
                'familyName' => 'Weiss',
                'givenName' => 'Geneviève',
                'email' => 'guillaume36@free.fr',
                'uuid' => 'c253424e-51db-45d1-8cc3-6db9006a9917',
                'locale' => LanguageEnum::FR,
                'password' => '1z!!!l.gj%`%T/vKFS7>',
            ],
            [
                'familyName' => 'Paris',
                'givenName' => 'Charles',
                'email' => 'arthur.peron@hotmail.fr',
                'uuid' => '34cb4c5c-f880-4b87-8d94-674ea40714de',
                'locale' => LanguageEnum::FR,
                'password' => '-4R./&=A!%O,s_4+0c4',
            ],
            [
                'familyName' => 'Sanchez',
                'givenName' => 'Françoise',
                'email' => 'moulin.helene@laposte.net',
                'uuid' => 'e529ef7c-9146-4cca-936b-f9fc4f28779e',
                'locale' => LanguageEnum::FR,
                'password' => 'Q+;VoF`o*IIS`',
            ],
            [
                'familyName' => 'Mahe',
                'givenName' => 'Margaux',
                'email' => 'aurore.mary@free.fr',
                'uuid' => '55bb4b8e-0544-4579-917f-7762cea12c18',
                'locale' => LanguageEnum::FR,
                'password' => '9flDgM*Qw"=p>lAOeb',
            ],
            [
                'familyName' => 'Barre',
                'givenName' => 'Bernadette',
                'email' => 'trolland@dbmail.com',
                'uuid' => '2da908c4-85a5-4834-b1e1-e01e90d50374',
                'locale' => LanguageEnum::FR,
                'password' => '2@>lZ!w6Vg<w\yWdN$]',
            ],
            [
                'familyName' => 'Turpin',
                'givenName' => 'Élisabeth',
                'email' => 'svaillant@noos.fr',
                'uuid' => 'e6777bdb-8d49-4563-9bea-477e1699f849',
                'locale' => LanguageEnum::FR,
                'password' => '3_]ZA:7{PJAX0|w.I',
            ],
            [
                'familyName' => 'Delannoy',
                'givenName' => 'Eugène',
                'email' => 'peron.timothee@noos.fr',
                'uuid' => '613779e9-c432-4312-a130-e853d5617530',
                'locale' => LanguageEnum::FR,
                'password' => 'OG5lCxp3y(3:S|',
            ],
        ];
    }
}
