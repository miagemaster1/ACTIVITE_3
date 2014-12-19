package miage.sudoku.test;


import static org.junit.Assert.assertEquals;

import java.io.IOException;

import miage.sudoku.main.Sudoku;

import org.junit.Test;

/**
 * 
 */

/**
 * @author 
 *
 */
public class TestSudoku {
	
	String nomfichier = "grille.txt";
	Sudoku s = new Sudoku();
	
	int[][] sudotest = {
			{0,5,6,0,3,9,0,8,1},
			{9,0,0,0,0,8,0,0,0},
			{0,8,0,0,0,2,3,0,9},
			{0,0,2,0,8,0,0,0,0},
			{0,0,7,6,0,0,2,0,4},
			{4,0,5,2,0,1,8,9,0},
			{3,4,8,0,0,0,1,6,0},
			{5,0,0,0,1,0,0,0,0},
			{0,0,0,3,5,4,0,2,8}
			};
	
	// test
	@SuppressWarnings("deprecation")
	@Test
	public void testLecture() throws IOException{
		assertEquals(sudotest, s.lecture(nomfichier));
	}
	
	
	// test
	@Test
	public void testLigneValide(){
		assertEquals(true, s.ligneValide(sudotest, 0));
		assertEquals(true, s.ligneValide(sudotest, 1));
		assertEquals(true, s.ligneValide(sudotest, 2));
		assertEquals(true, s.ligneValide(sudotest, 3));
		assertEquals(true, s.ligneValide(sudotest, 4));
		assertEquals(true, s.ligneValide(sudotest, 5));
		assertEquals(true, s.ligneValide(sudotest, 6));
		assertEquals(true, s.ligneValide(sudotest, 7));
		assertEquals(true, s.ligneValide(sudotest, 8));
	}
	
	// test
	@Test
	public void testColonneValide(){
		assertEquals(true, s.colonneValide(sudotest, 0));
		assertEquals(true, s.colonneValide(sudotest, 1));
		assertEquals(true, s.colonneValide(sudotest, 2));
		assertEquals(true, s.colonneValide(sudotest, 3));
		assertEquals(true, s.colonneValide(sudotest, 4));
		assertEquals(true, s.colonneValide(sudotest, 5));
		assertEquals(true, s.colonneValide(sudotest, 6));
		assertEquals(true, s.colonneValide(sudotest, 7));
		assertEquals(true, s.colonneValide(sudotest, 8));
	}
	

	
	@Test
	public void testCarreeValide(){
		assertEquals(true, s.carreeValide(sudotest,0,0));
		assertEquals(true, s.carreeValide(sudotest,0,3));
		assertEquals(true, s.carreeValide(sudotest,0,6));
		assertEquals(true, s.carreeValide(sudotest,3,0));
		assertEquals(true, s.carreeValide(sudotest,3,3));
		assertEquals(true, s.carreeValide(sudotest,3,6));
		assertEquals(true, s.carreeValide(sudotest,6,0));
		assertEquals(true, s.carreeValide(sudotest,6,3));
		assertEquals(true, s.carreeValide(sudotest,6,6));
	}
	
	
	@Test
	public void testValideSudoku(){
		assertEquals(true, s.valideSudoku(sudotest));
	}

}
