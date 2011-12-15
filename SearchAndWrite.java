package twitter;

import java.sql.*;
import java.text.ParseException;
import twitter4j.*;

import com.cybozu.labs.langdetect.Detector;
import com.cybozu.labs.langdetect.DetectorFactory;
import com.cybozu.labs.langdetect.LangDetectException;
import java.text.DateFormat;
import java.text.Format;
import java.text.SimpleDateFormat;

public class SearchMethod {
    public static void main (String args[]) throws TwitterException, SQLException, LangDetectException, ParseException {
        
        DetectorFactory.loadProfile("/Users/Andrey/Downloads/langdetect-09-13-2011/profiles/");
    
        Connection conn = DriverManager.getConnection(
            "jdbc:mysql://localhost/grupa2?useUnicode=yes&characterEncoding=utf8",
            "group2", "PU7CKJc8M7LwGzUc"
        );
        
        int n = 0;
        
        Statement selectDate = conn.createStatement();
        ResultSet rs = selectDate.executeQuery("SELECT MAX(date) FROM tweet");
        rs.next();
        String getDate = rs.getString("MAX(date)");
        
        Statement select = conn.createStatement();
        ResultSet select_result = select.executeQuery("SELECT id, text FROM brand WHERE parent_id!='NULL' AND parent_id!=0");

        while (select_result.next()){
            int id = select_result.getInt(1);
            String text = '"' + select_result.getString(2) + '"';
            n = searchForTwits(id, text, conn, getDate);
            System.out.println(n);
        }
        
        conn.close();
        
    } 
    
    public static int searchForTwits(int id, String text, Connection conn, String getDate) throws TwitterException, SQLException, LangDetectException, ParseException {
        Twitter twitter = new TwitterFactory().getInstance();
        int countTweets = 0;
        int pageNumber = 1;
        int n=0;

        
        do {
            Query query = new Query(text).rpp(100).page(pageNumber);
            QueryResult result = twitter.search(query);
            for (Tweet tweet : result.getTweets()) {
                
                
                java.util.Date date = tweet.getCreatedAt();
                Format formatter;
                formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                String newDate = formatter.format(date);
                
                DateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                java.util.Date oldDate = df.parse(getDate);
                
                Statement input = conn.createStatement();
                
                countTweets++;
                
                if (date.after(oldDate)) {
                    Detector detector = DetectorFactory.create();
                    detector.append(tweet.getText());
                    String lang;
                    try {
                        lang = detector.detect();

                            if (lang.equals("lv") || lang.equals("ru")) {
                                try {
                                    input.executeUpdate("INSERT INTO tweet " + "VALUES (null, '" + tweet.getId() + "', '" + tweet.getFromUser() + "', '" + tweet.getText().replace("'", "&rsquo;") + "', '" + newDate + "', null, null, null)");
                                    input.executeUpdate("INSERT INTO tweet_brand " + "VALUES (null, '" + tweet.getId() + "', '" + id + "')");
                                } 
                                catch (SQLException ex) {}
                                n++;
                            }
                            else continue;
                            
                    } catch (LangDetectException ex) {}
                }
                else continue;
            }
            pageNumber++;
            if (countTweets == 100) countTweets = 0;
            else break;
        }while (pageNumber != 16);
        
        System.out.print(text + " ");
        return n;
    }
}
