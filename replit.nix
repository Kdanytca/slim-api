{ pkgs }:
pkgs.mkShell {
  buildInputs = [
    pkgs.php82
    pkgs.composer
  ];
}
