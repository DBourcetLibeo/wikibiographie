<?php

    get_header();

    global $post;

    $w = new WikiBiographie();
    $meta = $w->get_biographie_custom_data($post->ID);
    $options = get_option('wikibiographie_options');

    function preview($text, $maxChars) {

        // If maxChars equals 0, then do not limit the number of characters
        if ($maxChars == 0) { return $text; }

        // If the text is shorter than the maximum number of characters, return the whole text
        if(mb_strlen($text) <= $maxChars) {
            return $text;
        }

        $text_truncated = mb_substr($text, 0, $maxChars);

        // If there is a dot in the truncated text, return the text up until the last sentence
        if (false !== mb_strpos($text_truncated, '.')) {
            return trim(pathinfo($text_truncated, PATHINFO_FILENAME), '.') . '.';
        }

        // If there is a spaces in the truncated text, return the text up until the last space
        if (false !== mb_strpos($text_truncated, ' ')) {
            $exploded = explode(' ', $text_truncated);
            array_pop($exploded);
            return implode(' ', $exploded) . '…';
        }

        return $text_truncated . '…';
    }

    $wiki = [
        'name' => $meta['_biographie_wiki_name'],
        'image' => $meta['_biographie_wiki_image'],
        'pseudo' => $meta['_biographie_wiki_pseudonym'],
        'dob' => $meta['_biographie_wiki_date_of_birth'],
        'pob' => $meta['_biographie_wiki_place_of_birth'],
        'dod' => $meta['_biographie_wiki_date_of_death'],
        'pod' => $meta['_biographie_wiki_place_of_death'],
        'occupation' => $meta['_biographie_wiki_occupation'],
        'website' => $meta['_biographie_wiki_website'],
        'introduction' => preview($meta['_biographie_wiki_introduction'], $options['_wikibiographie_maximum_description_length_in_characters']),
        'introduction_complement' => null,
    ];

    $custom = [
        'name' => $meta['_biographie_custom_name'],
        'image' => get_the_post_thumbnail_url(),
        'pseudo' => $meta['_biographie_custom_pseudo'],
        'dob' => $meta['_biographie_custom_date_naissance'],
        'pob' => $meta['_biographie_custom_lieu_naissance'],
        'dod' => $meta['_biographie_custom_date_deces'],
        'pod' => $meta['_biographie_custom_lieu_deces'],
        'occupation' => $meta['_biographie_custom_occupation'],
        'website' => $meta['_biographie_custom_site_officiel'],
        'introduction' => $meta['_biographie_custom_description'],
        'introduction_complement' => $meta['_biographie_custom_description_complementaire'],
    ];

    $mergeBio = function($wiki, $custom) {
        $bio = [];
        foreach ($wiki as $key => $value) {
            if (!empty($custom[$key])) {
                $bio[$key] = $custom[$key];
            } else {
                $bio[$key] = $wiki[$key];
            }
        }
        return $bio;
    };

    $bio = $mergeBio($wiki, $custom);

    $settings_mapping = [
        'name' => 'display_name',
        'image' => 'display_photo',
        'pseudo' => 'display_pseudonym',
        'dob' => 'display_date_of_birth',
        'pob' => 'display_place_of_birth',
        'dod' => 'display_date_of_death',
        'pod' => 'display_place_of_death',
        'occupation' => 'display_occupation',
        'website' => 'display_website',
        'introduction' => 'display_description',
        'introduction_complement' => 'display_description',
    ];

    foreach ($settings_mapping as $attr => $setting) {
        if (!($options[$setting] ?? true)) {
            unset($bio[$attr]);
        }
    }

?>

<a href="<?php echo get_post_type_archive_link( 'biographie' ); ?>">Toute les biographies</a>

<h2><?php _e("Biographie de : "); ?><?php the_title(); ?></h2>

<table class="bio-table">
    <?php if(!empty($bio['name'])): ?>
        <tr>
            <th>Nom</th>
            <td>
                <?php echo $bio['name']; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['image'])): ?>
        <tr>
            <th>Photo</th>
            <td>
                <img src="<?php echo $bio['image']; ?>" alt="Photo de <?php the_title(); ?>" style="max-width: 300px;">
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['pseudo'])): ?>
        <tr>
            <th>Pseudonyme</th>
            <td>
                <?php echo $bio['pseudo']; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['dob'])): ?>
        <tr>
            <th>Date de naissance</th>
            <td>
                <?php echo $bio['dob']; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['pob'])): ?>
        <tr>
            <th>Lieu de naissance</th>
            <td>
                <?php echo $bio['pob']; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['dod'])): ?>
        <tr>
            <th>Date de décès</th>
            <td>
                <?php echo $bio['dod']; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['pod'])): ?>
        <tr>
            <th>Lieu de décès</th>
            <td>
                <?php echo $bio['pod']; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['occupation'])): ?>
        <tr>
            <th>Occupation</th>
            <td>
                <?php echo $bio['occupation']; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['website'])): ?>
        <tr>
            <th>Site web</th>
            <td>
                <a href="<?php echo $bio['website']; ?>" target="_blank"><?php echo $bio['website']; ?></a>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($bio['introduction']) || !empty($bio['introduction_complement'])): ?>
        <tr>
            <th>Description</th>
            <td>
                <?php echo $bio['introduction']; ?>
                <?php if(!empty($bio['introduction_complement'])): ?>
                    <?php echo $bio['introduction_complement']; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>
</table>
<?php if(!empty($meta['_biographie_custom_wikipedia_url'])): ?>
<div class="source">
    <a target="_blank" href="https://creativecommons.org/licenses/by-sa/3.0/deed.fr">Contenu soumis à la licence CC-BY-SA 3.0</a>. Source : Article <em><a target="_blank" href="<?php echo $meta['_biographie_custom_wikipedia_url'] ?>"><?php echo the_title(); ?></a></em> de <a target="_blank" href="https://www.wikipedia.org/">Wikipédia</a></div>
</div>
<?php endif; ?>
<?php get_footer(); ?>