let
  nixpkgs = fetchTarball "https://github.com/NixOS/nixpkgs/tarball/nixos-24.05";
  pkgs = import nixpkgs { config = {}; overlays = []; };
in

pkgs.mkShellNoCC {
  packages = with pkgs; [
    # Dependencies
    nodejs
    (pkgs.php83.buildEnv {
      extensions = ({ enabled, all } : enabled ++ (with all; [
        curl
        xdebug
        pdo
        pdo_pgsql
      ]));
      extraConfig = ''
        xdebug.mode=debug
      '';
    })
    php83Packages.composer
    # Editor and tools
    helix
    neovim
    zellij
    gitui
    bat
  ];

  NODE_BIN = "${pkgs.nodejs}/bin/node";

  shellHook = ''
    # Function to startup everything with zellij
    function meetballs_editor() {
        # Setup the editor
        setup_meetballs_editor $1

        # Ensure npm dependencies are installed
        if [ ! -d node_modules ]; then
            echo "Installing npm dependencies"
            npm install
        fi

        # Ensure composer dependencies are installed
        if [ ! -d vendor ]; then
            echo "Installing composer dependencies"
            composer install
        fi

        # Check which compositor is running to ensure zellij has the right
        # clipboard support
        if [ -n "$XDG_SESSION_TYPE" ]; then
            if [ "$XDG_SESSION_TYPE" = "wayland" ]; then
                export WAYLAND_DISPLAY=wayland-0
            fi
        fi

        # Start zellij
        zellij --session meetballs-editor \
            --layout ./editor/layout.kdl \
            options --copy-on-select false


    }
    function setup_meetballs_editor() {
        # Set editor
        CHOSEN_EDITOR=$EDITOR
        # Get from args
        if [ -n "$1" ]; then
            CHOSEN_EDITOR=$1
        fi
        # If no editor is set, use neovim
        if [ -z "$CHOSEN_EDITOR" ]; then
            CHOSEN_EDITOR="nvim"
        fi
        export CHOSEN_EDITOR
    }

    bat <<EOF
        Welcome to Meetballs!

        I've included a few tools to get you started and dependencies for the
        project. You can use the pre-configured editor by running:

        $ meetballs_editor

        This will also install npm and composer dependencies if they are not
        already installed. If that command doesn't work, you can also run:

        $ zellij --session meetballs-editor --layout ./editor/layout.kdl options --copy-on-select false

        Which will launch the editor with the same layout.
    EOF
  '';
}
