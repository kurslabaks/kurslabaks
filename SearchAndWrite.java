package twitter;

import java.util.*;
import java.io.*;

public class SearchAndWrite {
    
    public static void main(String args[]) throws FileNotFoundException, IOException {
        int count = 0;
        String str;
        ArrayList al = new ArrayList();
        
        String userString = getStringFromUser();
        System.out.println("Searching for '" + userString + "' in file...");
        BufferedReader bf = openReadFile();
        BufferedWriter fw = openWriteFile();
        String line = readLine(bf);
        
        while (line != null) {
            int indexFound = checkLineAndFoundIndex(line, userString);
            if (indexFound > -1) {
                //writeFoundLineInFile(fw, line);
                writeFoundLineInArrayList(fw, line, al);
                count++;
            }
            line = readLine(bf);
        }
        
        writeUserStringAndFoundedLinesQuantity(fw, userString, count);
        
        for (int i = 0; i < al.size(); i++) {
            str = (String) al.get(i);
            writeFoundLineInFile(fw, str);
        }
        
        System.out.println(count);
        
        closeFiles(bf, fw);
        
    }
    
    public static String getStringFromUser() {
        System.out.print("Type a string: ");
        Scanner sc = new Scanner(System.in, "UTF-8");
        String userString = sc.nextLine();
        return userString;
    }
    
    public static BufferedReader openReadFile() throws FileNotFoundException, IOException {
	BufferedReader bf = new BufferedReader(new FileReader("/Users/Andrey/Downloads/1_milj_tw.txt"));
        return bf;
    }
    
    public static BufferedWriter openWriteFile() throws FileNotFoundException, IOException {
        BufferedWriter fw = new BufferedWriter(new FileWriter("/Users/Andrey/Downloads/1_milj_tw_filtered.txt", true));
        return fw;
    }
    
    public static String readLine(BufferedReader bf) throws IOException {
        String line = bf.readLine();
        return line;
    }
    
    public static int checkLineAndFoundIndex(String line, String userString) {
        int indexFound = line.indexOf(userString);
        return indexFound;
    }
    
    public static void writeFoundLineInArrayList(BufferedWriter fw, String line, ArrayList al) throws IOException {
        al.add(line);
    }
    
    public static void writeFoundLineInFile(BufferedWriter fw, String str) throws IOException {
        fw.write(str + "\n");
    }
    
    public static void writeUserStringAndFoundedLinesQuantity(BufferedWriter fw, String userString, int count) throws IOException {
        fw.write(userString + "\n");
        fw.write(count + "\n");
    }

    public static void closeFiles(BufferedReader bf, BufferedWriter fw) throws IOException {
        bf.close();
        fw.close();
    }
}