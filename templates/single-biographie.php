<?php
    get_header();
    $bio = (new WikiBiographie())->get_biographie(get_the_ID());
?>
<div class="default-max-width">

    <a href="<?php echo get_post_type_archive_link( 'biographie' ); ?>">Toutes les biographies</a>

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
                    <img src="<?php echo $bio['image']; ?>" alt="Photo de <?php the_title(); ?>" style="max-width: 200px;">
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

    <?php if(!empty($bio['wikipedia_url'])): ?>
        <div class="source">
            <a target="_blank" href="https://creativecommons.org/licenses/by-sa/3.0/deed.fr">Contenu soumis à la licence CC-BY-SA 3.0</a>. Source : Article <em><a target="_blank" href="<?php echo $bio['wikipedia_url'] ?>"><?php echo the_title(); ?></a></em> de <a target="_blank" href="https://www.wikipedia.org/">Wikipédia</a></div>
        </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>