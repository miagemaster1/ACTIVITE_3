package miage.sudoku.main;


import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

/**
 * 
 */

/**
 * @author 
 *
 */
public class Sudoku {
	
	public static class Clavier {
		
		/**
		 * lecture d'une chaîne
		 * @return
		 */
		public static String lireString (){
			String ligne_lue = null;
			try {
				InputStreamReader lecteur = new InputStreamReader (System.in);
				BufferedReader entree = new BufferedReader (lecteur);
				ligne_lue = entree.readLine();
			}
			catch (IOException err){
				System.exit(0);
			}
			return ligne_lue;
		}
		
		/**
		 * lecture d'un float
		 * @return
		 */
		public static float lireFloat (){
			float x = 0;
			try{
				String ligne_lue = lireString();
				x = Float.parseFloat(ligne_lue);
			}
			catch (NumberFormatException err){
				System.out.println("***Erreur de donnée***");
			}
			return x;
		}
		
		/**
		 * lecture d'un double
		 * @return
		 */
		public static double lireDouble (){
			double x = 0;
			try{
				String ligne_lue = lireString();
				x = Double.parseDouble(ligne_lue);
			}
			catch (NumberFormatException err){
				System.out.println("***Erreur de donnée***");
				System.exit(0);
			}
			return x;
		}
		
		/**
		 * lecture d'un int
		 * @return
		 */
		public static int lireInt(){
			int n = 0;
			try{
				String ligne_lue = lireString();
				n = Integer.parseInt(ligne_lue);
			}
			catch (NumberFormatException err){
				System.out.println("*** Erreur de donnée ***");
				System.exit(0);
			}
			return n;
		}
		
	}

	/**
	 * lecture d'un sudoku dans un fichier
	 * @param fichier contient le sudoku à lire
	 * @return la matrice associée au sudoku
	 * @throws IOException 
	 */
	public static int[][] lecture(String fichier) throws IOException{
		int i = 0, j;
		String t[] = new String [9];
		String ligne;
		int sudoku[][] = new int [9][9];
		File file = new File (fichier);
		if(!file.exists()){
			file.createNewFile();
		}
		BufferedReader entree = new BufferedReader (new FileReader (file));
		do {
			ligne = entree.readLine();
			if (ligne != null){
				System.out.println(ligne);
				t = ligne.split(",");
				System.out.println(t.length);
				for (j = 0; j < t.length; j++){
					sudoku[i][j] = Integer.parseInt(t[j]);
					
				}
				i++;
			}
		}
		while (ligne != null);
		entree.close();
		System.out.println("*** Fin du fichier ***");
		
		return sudoku;
	}

	
	/**
	 * affiche la matrice d'un sudoku
	 * @param sudo la matrice retournée par la fonction lecture
	 * 
	 */
	
	public static void affichage(int[][] sudo){
		for (int i = 0; i < 9; i++){
			for (int j = 0; j < 9; j++){
				System.out.print(sudo[i][j]);
				System.out.print(" ");
			}
			System.out.println();
		}
		
	}
	
	/**
	 * verifier si une ligne de sudoku est valide
	 * @param sudo une grille de sudoku
	 * @param numligne numéro de la ligne
	 * @return true si la ligne est valide
	 */
	public static boolean ligneValide (int[][] sudo, int numligne){
		boolean valide = true;
		int[] symbole = new int[10];
		List<Integer> liste = new ArrayList<Integer>();
		for (int i = 0; i < 10; i++){
			liste.add(i);
		}
		for (int i = 0; i < 9; i++){
			if (liste.contains(sudo[numligne][i])){
				symbole[sudo[numligne][i]]++;
			}
			else valide = false;
		}
		for (int j = 1; j < 10; j++){
			if (symbole[j] > 1){
				valide = false;
			}
		}
		
		return valide;
	}

	/**
	 * vérifier si une colonne de sudoku est valide
	 * @param sudo une grille de sudoku
	 * @param numcolonne numéro de la colonne
	 * @return true si la colonne est valide
	 */
	public static boolean colonneValide (int[][] sudo, int numcolonne){
		boolean valide = true;
		int[] symbole = new int[10];
		List<Integer> liste = new ArrayList<Integer>();
		for (int i = 0; i < 10; i++){
			liste.add(i);
		}
		for (int i = 0; i < 9; i++){
			if (liste.contains(sudo[i][numcolonne])){
				symbole[sudo[i][numcolonne]]++;
			}
			else valide = false;
		}
		for (int j = 1; j < 10; j++){
			if (symbole[j] > 1){
				valide = false;
			}
		}
		return valide;
	}
	
	/**
	 * vérifier si aucun carrée 3X3 ne contient deux fois le même chiffre compris entre 0 et 9
	 * @param i ligne supérieure gauche
	 * @param j colonne supérieure gauche
	 * @return true si le carrée est valide
	 */
	public static boolean carreeValide(int sudo[][], int ligne, int colonne){
		boolean valide = true;
		int[] symbole = new int[10]; // compter le nombre d'occ des symboles
		List<Integer> liste = new ArrayList<Integer>(); // liste des symboles autorisés
		for (int i = 0; i < 10; i++){
			liste.add(i);
		}
		for (int i = ligne; i < (ligne + 3); i++){
			for (int j = colonne; j < (colonne + 3); j++){
				if (liste.contains(sudo[i][j])){
					symbole[sudo[i][j]]++;
				}
				else valide = false;
			}
		}
		for (int j = 1; j < 10; j++){
			if (symbole[j] > 1){
				valide = false;
			}
		}
		
		return valide;
	}

	
	/**
	 * vérifier si une grille de sudoku est valide
	 * @param sudoku est la grille à vérifier
	 * @return true si la grille de sudoku est valide
	 */
	public static boolean valideSudoku (int [][] sudoku){
		boolean valide = true;
		for (int i = 0; i < 9; i++){
			if ((!ligneValide(sudoku, i))||(!colonneValide(sudoku, i))){
				valide = false;
			}
		}
		for (int i = 0; i < 9; i++){
			for (int j = 0; j < 9; j++){
				if (!carreeValide(sudoku, i, j)){
					valide = false;
				}
				j = j+2;
			}
			i = i+2;
		}
		return valide;
	}

	
	/**
	 * vérifier si une grille est rempli ie ne contient que des symboles autres que 0
	 * @param sudoku grille d'un sudoku
	 * @return true si la grille est remplie
	 */
	public static boolean grilleRemplie(int sudoku [][]){
		boolean rempli = true;
		if (valideSudoku(sudoku)){
			for (int i = 0; i < 9; i++){
				for (int j = 0; j < 9; j++){
					if (sudoku[i][j] == 0){
						rempli = false;
					}
				}
			}
		}
		else rempli = false;
		return rempli;
	}

	
	/**
	 * permet la saisie d'une proposition de l'utilisateur
	 * @param i la ligne à modifier
	 * @param j la colonne à modifier
	 */
	public static int [][] saisiSudoku(int sudoku[][], int ligne, int colonne){
		int nombre, n = sudoku[ligne][colonne];
		List<Integer> liste = new ArrayList<Integer>();
		for (int i = 0; i < 10; i++){
			liste.add(i);
		}
		if ((liste.contains(ligne))&&(liste.contains(colonne))){
			System.out.println("Entrer le symbole");
			nombre = Clavier.lireInt();
			if ((liste.contains(nombre))&&(sudoku[ligne][colonne] != 0)){
				sudoku[ligne][colonne] = nombre;
				if (!valideSudoku(sudoku)){
					sudoku[ligne][colonne] = n;
				}
			}
			else System.out.println("valeur incorrecte!!!");
		}
		else System.out.println("indice incorrecte!!!");
		return sudoku;
	}
	
	


	/**
	 * @param args
	 */
	public static void main(String[] args) {
		int i = 0 , j = 0;
		String nomfichier = new String();
		nomfichier = "grille";
		int sudo[][];
		try {
			sudo = lecture(nomfichier);
			affichage(sudo);
			while(!grilleRemplie(sudo)){
				System.out.println("Entrer les coordonnées de la case à modifier");
				i = Clavier.lireInt();
				j = Clavier.lireInt();
				sudo = saisiSudoku(sudo, i, j);
				affichage(sudo);
			}
			System.out.println("Bravo!!! vous avez gagnez");
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		
		// TODO Auto-generated method stub

	}

}