<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteContent;
use Illuminate\Support\Facades\DB;

class WebsiteContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to remove all existing records
        DB::table('website_contents')->truncate();
        
        $contents = [
            [
                'key' => 'site.logo',
                'content' => 'images/logo.jpeg',
                'is_active' => true,
            ],
            [
                'key' => 'site.title',
                'content' => 'এসএসসি ১২ ও এইচএসসি  ১৪ ব্যাচ',
                'is_active' => true,
            ],
            [
                'key' => 'site.subtitle',
                'content' => 'রক্তের বন্ধন অটুট থাক, জীবন বাঁচাতে রক্ত দিন',
                'is_active' => true,
            ],
            [
                'key' => 'site.name',
                'content' => 'OneTowOneFour',
                'is_active' => true,
            ],
            [
                'key' => 'footer.contact.address',
                'content' => 'SSC-12 & HSC-14 Batch, Medical College Gate, Dhaka',
                'is_active' => true,
            ],
            [
                'key' => 'footer.contact.phone',
                'content' => '+880 1234-567890',
                'is_active' => true,
            ],
            [
                'key' => 'footer.contact.email',
                'content' => 'info@one2one4.org',
                'is_active' => true,
            ],
            // Social Media Links
            [
                'key' => 'social.facebook',
                'content' => 'https://facebook.com/one2one4',
                'is_active' => true,
            ],
            [
                'key' => 'social.twitter',
                'content' => 'https://twitter.com/one2one4',
                'is_active' => true,
            ],
            [
                'key' => 'social.instagram',
                'content' => 'https://instagram.com/one2one4',
                'is_active' => true,
            ],
            [
                'key' => 'social.linkedin',
                'content' => 'https://linkedin.com/company/one2one4',
                'is_active' => true,
            ],
            [
                'key' => 'social.youtube',
                'content' => 'https://youtube.com/c/one2one4',
                'is_active' => true,
            ],
            [
                'key' => 'site.tagline',
                'content' => 'Connecting blood donors with recipients since 2024',
                'is_active' => true,
            ],
            [
                'key' => 'site.notification',
                'content' => 'আজকের রক্তদান শিবির - ২১ আগস্ট, ২০২৪ | বিস্তারিত জানতে যোগাযোগ করুন',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide1.title',
                'content' => 'Blood Donation',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide1.subtitle',
                'content' => 'Donating blood is quick, easy and safe',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide1.image',
                'content' => 'images/blood-donation-slide1.png',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide2.title',
                'content' => 'Save Lives',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide2.subtitle',
                'content' => 'Your donation can save up to three lives',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide2.image',
                'content' => 'images/blood-donation-slide2.png',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide3.title',
                'content' => 'Be a Hero',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide3.subtitle',
                'content' => 'Give the gift of life by donating blood today',
                'is_active' => true,
            ],
            [
                'key' => 'site.hero.slide3.image',
                'content' => 'images/blood-donation-slide3.png',
                'is_active' => true,
            ],

            [
                'key' => 'site.testimonials.title',
                'content' => 'WHAT OUR HEROES AND SURVIVORS SAY a',
                'is_active' => true,
            ],
            [
                'key' => 'site.testimonials.limit',
                'content' => '6',
                'is_active' => true,
            ],
            [
                'key' => 'site.logo_icon',
                'content' => 'images/logo-icon.png',
                'is_active' => true,
            ],
            // Sponsors Section
            [
                'key' => 'site.sponsors.title',
                'content' => 'OUR ESTEEMED SPONSORS',
                'is_active' => true,
            ],
            [
                'key' => 'site.sponsors.subtitle',
                'content' => 'Organizations supporting our mission to save lives through blood donation',
                'is_active' => true,
            ],
            [
                'key' => 'site.sponsors.limit',
                'content' => '8',
                'is_active' => true,
            ],
            [
                'key' => 'site.sponsors.cta.text',
                'content' => 'Become a Sponsor',
                'is_active' => true,
            ],
            [
                'key' => 'site.sponsors.cta.url',
                'content' => '#contact',
                'is_active' => true,
            ],
            // About Page Content
            [
                'key' => 'about.hero.title',
                'content' => 'About One2One4',
                'is_active' => true,
            ],
            [
                'key' => 'about.hero.description',
                'content' => 'A community-driven blood donation platform connecting donors and recipients from SSF 12 and HSF 14 batch to save lives through the gift of blood.',
                'is_active' => true,
            ],
            // About Page - Mission, Vision, Values
            [
                'key' => 'about.mission.title',
                'content' => 'Our Mission',
                'is_active' => true,
            ],
            [
                'key' => 'about.mission.content',
                'content' => 'To create a sustainable and efficient blood donation ecosystem that connects donors and recipients in real-time, ensuring that no life is lost due to lack of blood availability.',
                'is_active' => true,
            ],
            [
                'key' => 'about.vision.title',
                'content' => 'Our Vision',
                'is_active' => true,
            ],
            [
                'key' => 'about.vision.content',
                'content' => 'We are committed to fostering a culture of blood donation among friends from the SSC 12 and HSC 14 batches, with the aim of establishing the country\'s largest online blood donor bank based on our collaboration. By motivating our peers to actively participate in blood donation drives and engage in diverse social welfare initiatives, we aspire to make meaningful contributions to humanitarian efforts within our communities and across the nation. In addition to enlisting blood donors within our own batches, we seek to connect with voluntary donors from other cohorts and professions, enabling us to create a comprehensive and inclusive blood bank that will enhance our collective impact. Let the blood bond of 12/14 batches be stronger than ever & forever. "Together we stand, Divided we fall."',
                'is_active' => true,
            ],
            [
                'key' => 'about.values.title',
                'content' => 'Our Values',
                'is_active' => true,
            ],
            [
                'key' => 'about.values.content',
                'content' => 'We believe in compassion, reliability, transparency, and community service. Every action we take is guided by our commitment to saving lives and building strong bonds within our community.',
                'is_active' => true,
            ],
            // About Page - Journey Section
            [
                'key' => 'about.journey.title',
                'content' => 'Our Journey',
                'is_active' => true,
            ],
            [
                'key' => 'about.journey.content',
                'content' => 'One2One4 was founded in 2022 by a group of passionate individuals from SSF 12 and HSF 14 batch who recognized the critical need for an organized blood donation system within our community. What started as a small WhatsApp group for emergency blood requests has now evolved into a comprehensive platform that connects donors and recipients across Bangladesh.',
                'is_active' => true,
            ],
            // About Page - Milestones
            [
                'key' => 'about.milestone.2022',
                'content' => 'Initiated as a WhatsApp group for emergency blood requests among SSF 12 and HSF 14 batch members.',
                'is_active' => true,
            ],
            [
                'key' => 'about.milestone.2023',
                'content' => 'Expanded to a Facebook group with over 500 members and facilitated 100+ successful donations.',
                'is_active' => true,
            ],
            [
                'key' => 'about.milestone.2024',
                'content' => 'Launched the One2One4 platform with advanced features for matching donors and recipients in real-time.',
                'is_active' => true,
            ],
            // About Page - Team Section
            [
                'key' => 'about.team.title',
                'content' => 'Our Leadership Team',
                'is_active' => true,
            ],
            [
                'key' => 'about.team.description',
                'content' => 'Meet the dedicated individuals who make our mission possible through their tireless efforts and commitment.',
                'is_active' => true,
            ],
            // About Page - CTA Section
            [
                'key' => 'about.cta.title',
                'content' => 'Join Our Mission',
                'is_active' => true,
            ],
            [
                'key' => 'about.cta.description',
                'content' => 'Every drop counts. By donating blood, you\'re not just giving blood, you\'re giving someone another chance at life.',
                'is_active' => true,
            ],
            [
                'key' => 'about.cta.button',
                'content' => 'Become a Donor',
                'is_active' => true,
            ],
            // Gallery Page Content
            [
                'key' => 'gallery.title',
                'content' => 'Photo Gallery',
                'is_active' => true,
            ],
            [
                'key' => 'gallery.description',
                'content' => 'Explore our blood donation events, camps, and community activities through our beautiful photo gallery.',
                'is_active' => true,
            ],
            // Emergency Page Content
            [
                'key' => 'emergency.title',
                'content' => 'Emergency Blood Donor Contacts',
                'is_active' => true,
            ],
            [
                'key' => 'emergency.description',
                'content' => 'Need blood urgently? Contact these emergency hotlines or nearby donors immediately.',
                'is_active' => true,
            ],
            // Emergency Hotlines
            [
                'key' => 'emergency.hotline.1',
                'content' => json_encode([
                    'name' => 'National Blood Center',
                    'description' => '24/7 Emergency Blood Service',
                    'phone' => '+880 1234-567890'
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'emergency.hotline.2',
                'content' => json_encode([
                    'name' => 'City Hospital Blood Bank',
                    'description' => 'Emergency Blood Services',
                    'phone' => '+880 1234-567891'
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'emergency.hotline.3',
                'content' => json_encode([
                    'name' => 'Red Crescent Society',
                    'description' => 'Blood Donation Wing',
                    'phone' => '+880 1234-567892'
                ]),
                'is_active' => true,
            ],
            // Emergency Instructions
            [
                'key' => 'emergency.what_to_do.title',
                'content' => 'What to do in a blood emergency:',
                'is_active' => true,
            ],
            [
                'key' => 'emergency.what_to_do.content',
                'content' => json_encode([
                    'Stay calm and assess the situation.',
                    'Call the emergency hotlines listed here.',
                    'Provide details about the blood type needed and the hospital location.',
                    'Share the emergency requirement on social media platforms.',
                    'Contact family and friends who may be able to donate.'
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'emergency.required_info.title',
                'content' => 'Required Information:',
                'is_active' => true,
            ],
            [
                'key' => 'emergency.required_info.content',
                'content' => json_encode([
                    'Patient\'s name and age',
                    'Blood type required',
                    'Hospital name and location',
                    'Contact person and phone number',
                    'How many units are required',
                    'Reason for blood requirement (optional)'
                ]),
                'is_active' => true,
            ],
            // About Page - Team Members
            [
                'key' => 'about.team.member.1',
                'content' => json_encode([
                    'name' => 'Rafiqul Islam',
                    'position' => 'Founder & President',
                    'bio' => 'Passionate about creating a better healthcare system through technology and community engagement.',
                    'image' => 'images/team/team-1.jpg',
                    'social' => [
                        'facebook' => '#',
                        'twitter' => '#',
                        'linkedin' => '#'
                    ]
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'about.team.member.2',
                'content' => json_encode([
                    'name' => 'Nusrat Jahan',
                    'position' => 'Operations Director',
                    'bio' => 'Coordinates blood donation drives and manages the operational aspects of our platform.',
                    'image' => 'images/team/team-2.jpg',
                    'social' => [
                        'facebook' => '#',
                        'twitter' => '#',
                        'linkedin' => '#'
                    ]
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'about.team.member.3',
                'content' => json_encode([
                    'name' => 'Ashraful Haque',
                    'position' => 'Technical Lead',
                    'bio' => 'Oversees the development and maintenance of our digital platform and donation tracking system.',
                    'image' => 'images/team/team-3.jpg',
                    'social' => [
                        'facebook' => '#',
                        'twitter' => '#',
                        'linkedin' => '#'
                    ]
                ]),
                'is_active' => true,
            ],
            // Contact Page Content
            [
                'key' => 'contact.title',
                'content' => 'Get In Touch With Us',
                'is_active' => true,
            ],
            [
                'key' => 'contact.subtitle',
                'content' => 'Have questions about blood donation or need assistance? Our team is here to help you with any inquiries.',
                'is_active' => true,
            ],
            [
                'key' => 'contact.info.title',
                'content' => 'Blood Donation Network',
                'is_active' => true,
            ],
            [
                'key' => 'contact.info.tagline',
                'content' => 'Connecting donors and recipients since 2022',
                'is_active' => true,
            ],
            [
                'key' => 'contact.info.address',
                'content' => 'SSF-12 & HSF-14 Batch, Medical College Gate, Dhaka 1000, Bangladesh',
                'is_active' => true,
            ],
            [
                'key' => 'contact.info.phone',
                'content' => '+880 1234-567890',
                'is_active' => true,
            ],
            [
                'key' => 'contact.info.email',
                'content' => 'info@one2one4.org',
                'is_active' => true,
            ],
            [
                'key' => 'contact.info.hours',
                'content' => 'Sunday - Thursday: 9:00 AM - 5:00 PM<br>Friday & Saturday: Closed',
                'is_active' => true,
            ],
            [
                'key' => 'contact.form.title',
                'content' => 'Send Us Your Message',
                'is_active' => true,
            ],
    
            // Map iframe for contact page
            [
                'key' => 'contact.map_iframe',
                'content' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.762087871815!2d90.41284827590268!3d24.004176978985377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755db0026ea08cf%3A0x8c6e6c9fd3dfd772!2sAiO%20Innovation%20Limited!5e0!3m2!1sen!2sbd!4v1745849964158!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'is_active' => true,
            ],
            // Home Page Contact Section
            [
                'key' => 'home.contact.title',
                'content' => 'CONTACT US',
                'is_active' => true,
            ],
            [
                'key' => 'home.contact.description',
                'content' => 'Have questions about blood donation or need assistance? We\'re here to help!',
                'is_active' => true,
            ],
            [
                'key' => 'home.contact.info.title',
                'content' => 'Blood Donation Platform',
                'is_active' => true,
            ],
            [
                'key' => 'home.contact.info.tagline',
                'content' => 'Saving lives through voluntary blood donation',
                'is_active' => true,
            ],
            [
                'key' => 'home.contact.form.title',
                'content' => 'Send us a Message',
                'is_active' => true,
            ],
            [
                'key' => 'home.contact.button',
                'content' => 'Send Message',
                'is_active' => true,
            ],
            // Donors per page setting
            [
                'key' => 'donors.per_page',
                'content' => '15',
                'is_active' => true,
            ],
            // Gallery per page setting
            [
                'key' => 'gallery.per_page',
                'content' => '9',
                'is_active' => true,
            ],
            // Internal Programs Page Content
            [
                'key' => 'internal_program.title',
                'content' => 'Internal Programs Registration',
                'is_active' => true,
            ],
            [
                'key' => 'internal_program.subtitle',
                'content' => 'Join our exclusive internal programs for SSC-12 & HSC-14 batch members',
                'is_active' => true,
            ],
            [
                'key' => 'internal_program.description',
                'content' => 'Our internal programs are designed specifically for our batch members to strengthen our community bonds, promote blood donation awareness, and engage in social welfare activities. Register below to participate in upcoming events and receive your exclusive batch T-shirt.',
                'is_active' => true,
            ],
            [
                'key' => 'internal_program.registration.title',
                'content' => 'Program Registration',
                'is_active' => true,
            ],
            [
                'key' => 'internal_program.payment.instructions',
                'content' => 'Please complete your registration by making a payment of 500 BDT using one of the available payment methods. Upload a screenshot of your payment for verification.',
                'is_active' => true,
            ],
            [
                'key' => 'internal_program.contact.info',
                'content' => 'For any queries regarding registration or payment, please contact our program coordinator at +880 1234-567890 or email at programs@one2one4.org',
                'is_active' => true,
            ]
        ];

        foreach ($contents as $content) {
            WebsiteContent::create($content);
        }
    }
} 