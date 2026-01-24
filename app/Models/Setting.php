<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = [
        'site_name', 'address', 'copyright',
        'welcome_title', 'welcome_subtitle', 'welcome_btn_1_text', 'welcome_btn_2_text',
        'about_title', 'about_description',
        'team_title', 'team_description',
        'skills_title', 'skills_description',
        'services_title', 'services_description', 'services_sub_title', 'services_sub_description',
        'portfolio_title', 'portfolio_description',
        'blog_title', 'blog_description',
        'contact_title', 'contact_description',
        'cta_text', 'cta_button1_text', 'cta_button2_text'
    ];

    // Helper to generate accessors dynamically? No, must be explicit for IDE/Laravel detection sometimes.
    // I Will write specific ones for key fields used in index.blade.php.
    // Actually, I can use __call logic but attributes are better.
    // I will write only the ones strictly needed for now to save space, but logically should be all.
    // Given the length limit, I will implement a trait or just a few.
    // Limit: I'll implement `getAttribute` override? No, Spatie does that.
    // I need `getNameEnAttribute` style.

    // To avoid huge file, I will rely on the fact that I can use standard accessors.
    // But I will list them all.



    // ... for all others. I will use a smarter way in Form if possible.
    // But Form needs `dehydrate`.
    // Actually, if I don't add accessors, `TextInput::make('site_name_en')` won't work.
    // UNLESS I implement `__get` and `__set` magic for `_en` and `_ar` suffixes?
    // That would save 200 lines of code.

    // Accessors for Site Name
    public function getSiteNameEnAttribute() { return $this->getTranslation('site_name', 'en', false); }
    public function setSiteNameEnAttribute($value) { $this->setTranslation('site_name', 'en', $value); }
    public function getSiteNameArAttribute() { return $this->getTranslation('site_name', 'ar', false); }
    public function setSiteNameArAttribute($value) { $this->setTranslation('site_name', 'ar', $value); }

    // Accessors for Address
    public function getAddressEnAttribute() { return $this->getTranslation('address', 'en', false); }
    public function setAddressEnAttribute($value) { $this->setTranslation('address', 'en', $value); }
    public function getAddressArAttribute() { return $this->getTranslation('address', 'ar', false); }
    public function setAddressArAttribute($value) { $this->setTranslation('address', 'ar', $value); }

    // Accessors for Copyright
    public function getCopyrightEnAttribute() { return $this->getTranslation('copyright', 'en', false); }
    public function setCopyrightEnAttribute($value) { $this->setTranslation('copyright', 'en', $value); }
    public function getCopyrightArAttribute() { return $this->getTranslation('copyright', 'ar', false); }
    public function setCopyrightArAttribute($value) { $this->setTranslation('copyright', 'ar', $value); }

    // Accessors for Welcome Section
    public function getWelcomeTitleEnAttribute() { return $this->getTranslation('welcome_title', 'en', false); }
    public function setWelcomeTitleEnAttribute($value) { $this->setTranslation('welcome_title', 'en', $value); }
    public function getWelcomeTitleArAttribute() { return $this->getTranslation('welcome_title', 'ar', false); }
    public function setWelcomeTitleArAttribute($value) { $this->setTranslation('welcome_title', 'ar', $value); }
    
    public function getWelcomeSubtitleEnAttribute() { return $this->getTranslation('welcome_subtitle', 'en', false); }
    public function setWelcomeSubtitleEnAttribute($value) { $this->setTranslation('welcome_subtitle', 'en', $value); }
    public function getWelcomeSubtitleArAttribute() { return $this->getTranslation('welcome_subtitle', 'ar', false); }
    public function setWelcomeSubtitleArAttribute($value) { $this->setTranslation('welcome_subtitle', 'ar', $value); }

    public function getWelcomeBtn1TextEnAttribute() { return $this->getTranslation('welcome_btn_1_text', 'en', false); }
    public function setWelcomeBtn1TextEnAttribute($value) { $this->setTranslation('welcome_btn_1_text', 'en', $value); }
    public function getWelcomeBtn1TextArAttribute() { return $this->getTranslation('welcome_btn_1_text', 'ar', false); }
    public function setWelcomeBtn1TextArAttribute($value) { $this->setTranslation('welcome_btn_1_text', 'ar', $value); }

    public function getWelcomeBtn2TextEnAttribute() { return $this->getTranslation('welcome_btn_2_text', 'en', false); }
    public function setWelcomeBtn2TextEnAttribute($value) { $this->setTranslation('welcome_btn_2_text', 'en', $value); }
    public function getWelcomeBtn2TextArAttribute() { return $this->getTranslation('welcome_btn_2_text', 'ar', false); }
    public function setWelcomeBtn2TextArAttribute($value) { $this->setTranslation('welcome_btn_2_text', 'ar', $value); }

    // Accessors for About Section
    public function getAboutTitleEnAttribute() { return $this->getTranslation('about_title', 'en', false); }
    public function setAboutTitleEnAttribute($value) { $this->setTranslation('about_title', 'en', $value); }
    public function getAboutTitleArAttribute() { return $this->getTranslation('about_title', 'ar', false); }
    public function setAboutTitleArAttribute($value) { $this->setTranslation('about_title', 'ar', $value); }

    public function getAboutDescriptionEnAttribute() { return $this->getTranslation('about_description', 'en', false); }
    public function setAboutDescriptionEnAttribute($value) { $this->setTranslation('about_description', 'en', $value); }
    public function getAboutDescriptionArAttribute() { return $this->getTranslation('about_description', 'ar', false); }
    public function setAboutDescriptionArAttribute($value) { $this->setTranslation('about_description', 'ar', $value); }

    // Accessors for Team Section
    public function getTeamTitleEnAttribute() { return $this->getTranslation('team_title', 'en', false); }
    public function setTeamTitleEnAttribute($value) { $this->setTranslation('team_title', 'en', $value); }
    public function getTeamTitleArAttribute() { return $this->getTranslation('team_title', 'ar', false); }
    public function setTeamTitleArAttribute($value) { $this->setTranslation('team_title', 'ar', $value); }

    public function getTeamDescriptionEnAttribute() { return $this->getTranslation('team_description', 'en', false); }
    public function setTeamDescriptionEnAttribute($value) { $this->setTranslation('team_description', 'en', $value); }
    public function getTeamDescriptionArAttribute() { return $this->getTranslation('team_description', 'ar', false); }
    public function setTeamDescriptionArAttribute($value) { $this->setTranslation('team_description', 'ar', $value); }

    // Accessors for Skills Section
    public function getSkillsTitleEnAttribute() { return $this->getTranslation('skills_title', 'en', false); }
    public function setSkillsTitleEnAttribute($value) { $this->setTranslation('skills_title', 'en', $value); }
    public function getSkillsTitleArAttribute() { return $this->getTranslation('skills_title', 'ar', false); }
    public function setSkillsTitleArAttribute($value) { $this->setTranslation('skills_title', 'ar', $value); }

    public function getSkillsDescriptionEnAttribute() { return $this->getTranslation('skills_description', 'en', false); }
    public function setSkillsDescriptionEnAttribute($value) { $this->setTranslation('skills_description', 'en', $value); }
    public function getSkillsDescriptionArAttribute() { return $this->getTranslation('skills_description', 'ar', false); }
    public function setSkillsDescriptionArAttribute($value) { $this->setTranslation('skills_description', 'ar', $value); }

    // Accessors for Services Section
    public function getServicesTitleEnAttribute() { return $this->getTranslation('services_title', 'en', false); }
    public function setServicesTitleEnAttribute($value) { $this->setTranslation('services_title', 'en', $value); }
    public function getServicesTitleArAttribute() { return $this->getTranslation('services_title', 'ar', false); }
    public function setServicesTitleArAttribute($value) { $this->setTranslation('services_title', 'ar', $value); }

    public function getServicesDescriptionEnAttribute() { return $this->getTranslation('services_description', 'en', false); }
    public function setServicesDescriptionEnAttribute($value) { $this->setTranslation('services_description', 'en', $value); }
    public function getServicesDescriptionArAttribute() { return $this->getTranslation('services_description', 'ar', false); }
    public function setServicesDescriptionArAttribute($value) { $this->setTranslation('services_description', 'ar', $value); }

    public function getServicesSubTitleEnAttribute() { return $this->getTranslation('services_sub_title', 'en', false); }
    public function setServicesSubTitleEnAttribute($value) { $this->setTranslation('services_sub_title', 'en', $value); }
    public function getServicesSubTitleArAttribute() { return $this->getTranslation('services_sub_title', 'ar', false); }
    public function setServicesSubTitleArAttribute($value) { $this->setTranslation('services_sub_title', 'ar', $value); }

    public function getServicesSubDescriptionEnAttribute() { return $this->getTranslation('services_sub_description', 'en', false); }
    public function setServicesSubDescriptionEnAttribute($value) { $this->setTranslation('services_sub_description', 'en', $value); }
    public function getServicesSubDescriptionArAttribute() { return $this->getTranslation('services_sub_description', 'ar', false); }
    public function setServicesSubDescriptionArAttribute($value) { $this->setTranslation('services_sub_description', 'ar', $value); }

    // Accessors for Portfolio Section
    public function getPortfolioTitleEnAttribute() { return $this->getTranslation('portfolio_title', 'en', false); }
    public function setPortfolioTitleEnAttribute($value) { $this->setTranslation('portfolio_title', 'en', $value); }
    public function getPortfolioTitleArAttribute() { return $this->getTranslation('portfolio_title', 'ar', false); }
    public function setPortfolioTitleArAttribute($value) { $this->setTranslation('portfolio_title', 'ar', $value); }

    public function getPortfolioDescriptionEnAttribute() { return $this->getTranslation('portfolio_description', 'en', false); }
    public function setPortfolioDescriptionEnAttribute($value) { $this->setTranslation('portfolio_description', 'en', $value); }
    public function getPortfolioDescriptionArAttribute() { return $this->getTranslation('portfolio_description', 'ar', false); }
    public function setPortfolioDescriptionArAttribute($value) { $this->setTranslation('portfolio_description', 'ar', $value); }

    // Accessors for Blog Section
    public function getBlogTitleEnAttribute() { return $this->getTranslation('blog_title', 'en', false); }
    public function setBlogTitleEnAttribute($value) { $this->setTranslation('blog_title', 'en', $value); }
    public function getBlogTitleArAttribute() { return $this->getTranslation('blog_title', 'ar', false); }
    public function setBlogTitleArAttribute($value) { $this->setTranslation('blog_title', 'ar', $value); }

    public function getBlogDescriptionEnAttribute() { return $this->getTranslation('blog_description', 'en', false); }
    public function setBlogDescriptionEnAttribute($value) { $this->setTranslation('blog_description', 'en', $value); }
    public function getBlogDescriptionArAttribute() { return $this->getTranslation('blog_description', 'ar', false); }
    public function setBlogDescriptionArAttribute($value) { $this->setTranslation('blog_description', 'ar', $value); }

    // Accessors for Contact Section
    public function getContactTitleEnAttribute() { return $this->getTranslation('contact_title', 'en', false); }
    public function setContactTitleEnAttribute($value) { $this->setTranslation('contact_title', 'en', $value); }
    public function getContactTitleArAttribute() { return $this->getTranslation('contact_title', 'ar', false); }
    public function setContactTitleArAttribute($value) { $this->setTranslation('contact_title', 'ar', $value); }

    public function getContactDescriptionEnAttribute() { return $this->getTranslation('contact_description', 'en', false); }
    public function setContactDescriptionEnAttribute($value) { $this->setTranslation('contact_description', 'en', $value); }
    public function getContactDescriptionArAttribute() { return $this->getTranslation('contact_description', 'ar', false); }
    public function setContactDescriptionArAttribute($value) { $this->setTranslation('contact_description', 'ar', $value); }

    // Accessors for CTA Section
    public function getCtaTextEnAttribute() { return $this->getTranslation('cta_text', 'en', false); }
    public function setCtaTextEnAttribute($value) { $this->setTranslation('cta_text', 'en', $value); }
    public function getCtaTextArAttribute() { return $this->getTranslation('cta_text', 'ar', false); }
    public function setCtaTextArAttribute($value) { $this->setTranslation('cta_text', 'ar', $value); }

    public function getCtaButton1TextEnAttribute() { return $this->getTranslation('cta_button1_text', 'en', false); }
    public function setCtaButton1TextEnAttribute($value) { $this->setTranslation('cta_button1_text', 'en', $value); }
    public function getCtaButton1TextArAttribute() { return $this->getTranslation('cta_button1_text', 'ar', false); }
    public function setCtaButton1TextArAttribute($value) { $this->setTranslation('cta_button1_text', 'ar', $value); }

    public function getCtaButton2TextEnAttribute() { return $this->getTranslation('cta_button2_text', 'en', false); }
    public function setCtaButton2TextEnAttribute($value) { $this->setTranslation('cta_button2_text', 'en', $value); }
    public function getCtaButton2TextArAttribute() { return $this->getTranslation('cta_button2_text', 'ar', false); }
    public function setCtaButton2TextArAttribute($value) { $this->setTranslation('cta_button2_text', 'ar', $value); }
}
