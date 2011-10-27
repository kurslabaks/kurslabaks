package tweeter;

// Import io so we can use file objects

import java.util.*;
import java.io.*;

public class SearchAndWrite {
    
    public static void main(String args[]) throws FileNotFoundException, IOException {
        int count = 0;
        
        String userString = getStringFromUser();
        System.out.println("Searching for '" + userString + "' in file...");
        BufferedReader bf = openReadFile();
        BufferedWriter fw = openWriteFile();
        searchInFileForUserString(bf, fw, userString);
        
        while (bf != null) {
            int indexFound = findexFound(foundLine, userString);
            if (indexFound > -1) {
                fw.write(foundLine + "\n");
            }
        }
        
        closeFiles(bf, fw);
        
    }
    
    public static String getStringFromUser() {
        System.out.print("Type a string: ");
        Scanner sc = new Scanner(System.in);
        String userString = sc.nextLine();
        return userString;
    }
    
    public static BufferedReader openReadFile() throws FileNotFoundException, IOException {
	BufferedReader bf = new BufferedReader(new FileReader("/Users/Andrey/Downloads/1_milj_tw_test.txt"));
        return bf;
    }
    
    public static BufferedWriter openWriteFile() throws FileNotFoundException, IOException {
        BufferedWriter fw = new BufferedWriter(new FileWriter("/Users/Andrey/Downloads/1_milj_tw_filtered.txt", true));
        return fw;
    }
    
    public static void searchInFileForUserString(BufferedReader bf, BufferedWriter fw, String userString) throws IOException {
        String foundLine;
        while (( foundLine = bf.readLine()) != null) {
            int indexfound = foundLine.indexOf(userString);
            if (indexfound > -1) {
                fw.write(foundLine + "\n");
            }
        }
    }
    
    public static int indexFound(String foundLine, String userString) {
        int indexFound = foundLine.indexOf(userString);
        return indexFound;
    }
    
    public static void writeFoundLineInFile(BufferedWriter fw, String foundLine) throws IOException {
        fw.write(foundLine + "\n");
    }
    
    public static void writeUserStringAndFoundedLinesQuantity(BufferedWriter fw, String userString, int count) throws IOException {
        fw.write(userString + "\n");
        fw.write(count + "\n\n");
    }

    public static void closeFiles(BufferedReader bf, BufferedWriter fw) throws IOException {
        bf.close();
        fw.close();
    }
}

/*
 *         
        ArrayList al = new ArrayList();
        
        System.out.print("Type a string: ");
        Scanner sc = new Scanner(System.in);
        String userString = sc.nextLine();

	System.out.println("Searching for '" + userString + "' in file...");
        
        while (( line = bf.readLine()) != null) {
            linecount++;
            int indexfound = line.indexOf(userString);
            if (indexfound > -1) {
                fw.write(line + "\n");
                al.add(line);
                count++;
            }
	}
	
        al.add(userString);
        fw.write(userString + "\n");
        al.add(count);
        fw.write(count + "\n\n");

	bf.close();
        fw.close();
        
        for (int i = 0; i < al.size(); i++)
        {
            System.out.println(al.get(i));
        }
    
    }
 */