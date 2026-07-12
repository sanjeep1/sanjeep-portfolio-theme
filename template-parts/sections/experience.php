<?php
/**
 * Template Part: Experience Section
 * Location: template-parts/sections/experience.php
 */
$experience_subtitle = get_field('experience_subtitle');
$experience_heading = get_field('experience_heading');
$experiences = function_exists( 'get_field' ) ? get_field( 'experiences') : [];


$items = function_exists('get_field') ? get_field('experiences') : [];

if (empty($items)) {
    return;
}
?>

<section id="experience"
    class="py-20 px-16 bg-sp-bg-2 border-t border-sp-border overflow-hidden"
    aria-labelledby="experience-heading">

    <div class="max-w-screen-xl mx-auto">

        <!-- Section header -->
        <div class="section-label reveal">
            <?php echo esc_html($experience_subtitle); ?>
        </div>

        <h2 id="experience-heading" class="section-title reveal">
            <?php echo esc_html($experience_heading); ?><span class="text-sp-accent">.</span>
        </h2>

        <!-- ── TIMELINE ── -->
        <div class="tl-wrap reveal" id="sp-timeline" role="list" aria-label="<?php esc_attr_e( 'Work experience timeline', 'sanjeep-portfolio' ); ?>">

            <!-- Vertical line -->
            <div class="tl-line" aria-hidden="true">
                <div class="tl-line-fill" id="sp-tl-fill"></div>
            </div>

            <?php foreach ( $items as $i => $exp ) :
                $year_start  = $exp['exp_year_start']  ?? '';
                $year_end    = $exp['exp_year_end']     ?? '';
                // $duration    = $exp['exp_duration']     ?? '';
                $role        = $exp['exp_role']         ?? '';
                $company     = $exp['exp_company']      ?? '';
                $is_current  = ! empty( $exp['exp_current'] );
                $description = $exp['exp_description']  ?? '';
                $tags        = $exp['exp_tags']         ?? [];
                $delay       = $i * 100;

                $duration = '';

                if (!empty($year_start)) {

                    try {

                        $start = DateTime::createFromFormat('F Y', trim($year_start));

                        if ($start) {

                            if ($is_current) {
                                $end = new DateTime();
                            } elseif (!empty($year_end)) {
                                $end = DateTime::createFromFormat('F Y', trim($year_end));
                            }

                            if (!empty($end)) {

                                $interval = $start->diff($end);

                                $parts = [];

                                if ($interval->y > 0) {
                                    $parts[] = $interval->y . ' yr' . ($interval->y > 1 ? 's' : '');
                                }

                                if ($interval->m > 0) {
                                    $parts[] = $interval->m . ' mo';
                                }

                                if (empty($parts)) {
                                    $parts[] = 'Less than 1 mo';
                                }

                                $duration = implode(' ', $parts);
                            }
                        }

                    } catch (Exception $e) {
                        $duration = '';
                    }
                }
                
                $year_label = '';

                if ($year_start) {
                    $year_label = esc_html($year_start) . ' — ' . ($is_current ? 'Present' : esc_html($year_end));
                }
                
                $item_classes = 'tl-item reveal';
                if ( $is_current ) $item_classes .= ' tl-item--current';
            ?>

            <div
                class="<?php echo esc_attr( $item_classes ); ?>
                relative grid
                grid-cols-[24px_1fr]
                md:grid-cols-[200px_32px_1fr]
                pb-16"
                role="listitem"
                style="animation-delay: <?php echo absint( $delay ); ?>ms"
                aria-label="<?php echo esc_attr( $role . ' at ' . $company ); ?>">

                <!-- Left: date -->
                <div class="hidden md:flex flex-col items-end text-right pr-10 pt-1">
                    <?php if ( $year_label ) : ?>
                    <span class="font-mono text-xs uppercase tracking-[0.15em] text-sp-accent"><?php echo wp_kses_post( $year_label ); ?></span>
                    <?php endif; ?>

                    <?php if ( $duration ) : ?>
                        <span class="font-mono text-[11px] uppercase tracking-wider text-sp-text-muted mt-1"><?php echo esc_html( $duration ); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Dot -->
                <div class="relative flex justify-start md:justify-center" aria-hidden="true">
                    <div class="relative z-10 mt-1 w-3 h-3 rounded-full border-2
                        <?php echo $is_current
                            ? 'border-sp-accent bg-sp-accent shadow-[0_0_0_6px_rgba(200,240,74,0.15)]'
                            : 'border-sp-border bg-sp-bg'; ?>"></div>
                </div>

                <!-- Right: content -->
                <div class="pl-4 md:pl-8">

                    <?php if ( $role ) : ?>
                    <h3 class="font-display font-bold text-2xl text-sp-text-primary mb-2"><?php echo esc_html( $role ); ?></h3>
                    <?php endif; ?>

                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        <?php if ( $company ) : ?>
                        <span class="font-mono text-sm uppercase tracking-wider text-sp-text-secondary"><?php echo esc_html( $company ); ?></span>
                        <?php endif; ?>

                        <?php if ( $is_current ) : ?>
                        <span class="px-2 py-1 border border-sp-accent/30 text-[10px] uppercase tracking-[0.15em] text-sp-accent font-mono" aria-label="<?php esc_attr_e( 'Current position', 'sanjeep-portfolio' ); ?>">
                            <?php esc_html_e( 'Current', 'sanjeep-portfolio' ); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <?php if ( $description ) : ?>
                    <p class="text-base leading-relaxed text-sp-text-secondary mb-6 max-w-4xl"><?php echo esc_html( $description ); ?></p>
                    <?php endif; ?>

                    <?php if ( ! empty( $tags ) ) : ?>
                    <div class="flex flex-wrap gap-2"
                         aria-label="<?php esc_attr_e( 'Technologies used', 'sanjeep-portfolio' ); ?>">
                        <?php foreach ( $tags as $tag ) :
                            $label = is_array( $tag ) ? ( $tag['exp_tag'] ?? '' ) : $tag;
                            if ( ! $label ) continue;
                        ?>
                        <span class="px-3 py-1 border border-sp-border text-xs uppercase tracking-wider font-mono text-sp-text-muted rounded-sm">
                            <?php echo esc_html( $label ); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>

            </div>
            <?php endforeach; ?>

        </div><!-- /.tl-wrap -->

    </div><!-- /.max-w-screen-xl -->
</section>
