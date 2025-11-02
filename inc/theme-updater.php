<?php
/**
 * GitHub Theme Updater
 *
 * Enables WordPress to check for theme updates from GitHub releases.
 */

class Tamgaci_GitHub_Updater {
    private $github_username = 'mugulhan';
    private $github_repo = 'tamgaci';
    private $theme_slug = 'tamgaci';
    private $version;
    private $github_response;

    public function __construct() {
        $theme = wp_get_theme( $this->theme_slug );
        $this->version = $theme->get( 'Version' );

        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_update' ) );
        add_filter( 'upgrader_source_selection', array( $this, 'fix_update_folder' ), 10, 3 );
    }

    /**
     * Get GitHub API response
     */
    private function get_github_data() {
        if ( ! empty( $this->github_response ) ) {
            return;
        }

        $request_uri = sprintf(
            'https://api.github.com/repos/%s/%s/releases/latest',
            $this->github_username,
            $this->github_repo
        );

        $response = wp_remote_get( $request_uri );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $response = json_decode( wp_remote_retrieve_body( $response ) );

        if ( ! empty( $response ) ) {
            $this->github_response = $response;
        }
    }

    /**
     * Check for theme updates
     */
    public function check_update( $transient ) {
        if ( empty( $transient->checked ) ) {
            return $transient;
        }

        $this->get_github_data();

        if ( ! $this->github_response || empty( $this->github_response->tag_name ) ) {
            return $transient;
        }

        // Get latest version from GitHub (remove 'v' prefix if exists)
        $github_version = ltrim( $this->github_response->tag_name, 'v' );

        // Compare versions
        if ( version_compare( $this->version, $github_version, '<' ) ) {
            // Find the deployment ZIP asset
            $package_url = $this->github_response->zipball_url;

            if ( ! empty( $this->github_response->assets ) ) {
                foreach ( $this->github_response->assets as $asset ) {
                    if ( strpos( $asset->name, 'tamgaci-v' ) === 0 && strpos( $asset->name, '.zip' ) !== false ) {
                        $package_url = $asset->browser_download_url;
                        break;
                    }
                }
            }

            $theme_data = array(
                'theme'       => $this->theme_slug,
                'new_version' => $github_version,
                'url'         => $this->github_response->html_url,
                'package'     => $package_url,
            );

            $transient->response[ $this->theme_slug ] = $theme_data;
        }

        return $transient;
    }

    /**
     * Fix the update folder name
     *
     * GitHub zipballs extract to a folder like "username-reponame-commit"
     * We need to rename it to just the theme slug
     */
    public function fix_update_folder( $source, $remote_source, $upgrader ) {
        global $wp_filesystem;

        // Only process theme updates
        if ( ! isset( $upgrader->skin->theme ) ) {
            return $source;
        }

        // Only process our theme
        if ( $upgrader->skin->theme !== $this->theme_slug ) {
            return $source;
        }

        // Get the correct destination
        $destination = trailingslashit( $remote_source ) . $this->theme_slug;

        // Rename the folder
        if ( $wp_filesystem->move( $source, $destination ) ) {
            return $destination;
        }

        return $source;
    }
}

// Initialize the updater
new Tamgaci_GitHub_Updater();
