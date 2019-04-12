package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;

public class Files extends AppCompatActivity {

    ArrayList<files_class> arrayList = new ArrayList<>();
   CustomAdapter3 adapter;
    ProgressDialog pd;
    String id,code;
    LinearLayout ll;
    FilesLoader filesloader;
    ListView list;
    TextView title;
    String roll;
    @Override
    protected void onPause() {
        super.onPause();
        if(filesloader.getStatus()==AsyncTask.Status.RUNNING)
        filesloader.cancel(true);
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                Files.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_files);

        ll = (LinearLayout) findViewById(R.id.linear_notes);
        ll.setVisibility(View.INVISIBLE);
        id=getIntent().getStringExtra("id");
        code=getIntent().getStringExtra("code");

        roll = getIntent().getStringExtra("roll");
        filesloader = new FilesLoader(this);
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle(code.toUpperCase()+"'s Files");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);

        list = (ListView) findViewById(R.id.files_listview);
        if(isNetworkAvailable()) {

            filesloader.execute();

            Handler handler = new Handler();
            handler.postDelayed(new Runnable()
            {
                @Override
                public void run() {
                    if ( filesloader.getStatus() == AsyncTask.Status.RUNNING )
                    {filesloader.cancel(true);
                        Toast.makeText(Files.this, "Time OUT", Toast.LENGTH_SHORT).show();
                        if(pd.isIndeterminate())
                        pd.dismiss();
                    }
                }
            }, 20000 );
        }
        else{
            Toast.makeText(Files.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
        }
        adapter=new CustomAdapter3(Files.this,arrayList);
        list.setAdapter(adapter);

        list.setOnItemClickListener(
                new AdapterView.OnItemClickListener() {
                    public void onItemClick(AdapterView<?> parent, View v, int pos, long id) {

                        files_class files_class = arrayList.get(pos);

                        Intent i = new Intent(Intent.ACTION_VIEW, Uri.parse("https://exodia-incredible100rav.c9users.io/exodia/download.php?file="+files_class.getPdf()+""));
                        startActivity(i);


                    }
                }


        );

    }
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }


    class CustomAdapter3 extends ArrayAdapter<files_class> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<files_class> arrayList) {
            super(context, R.layout.files_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {

            LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
            convertView = li.inflate(R.layout.files_card, parent, false);

            files_class files_class = getItem(pos);

            TextView file_name = (TextView) convertView.findViewById(R.id.files_title);

            TextView file_desc = (TextView) convertView.findViewById(R.id.files_desc);

            TextView file_teacher = (TextView) convertView.findViewById(R.id.files_teacher);

            file_name.setText(files_class.getTitle());
            file_desc.setText(files_class.getDesc());
            file_teacher.setText("- " + files_class.getTeacher());

            return convertView;

        }
    }


    public class FilesLoader extends AsyncTask<Void,Void,String> {

        Context context;
        FilesLoader(Context context)
        {
            this.context=context;
        }


        @Override
        protected String doInBackground(Void... params) {

            String login_url= "https://exodia-incredible100rav.c9users.io/android/php/getfiles.php";

            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("id", "UTF-8") + "=" + URLEncoder.encode(id, "UTF-8") + "&"
                        + URLEncoder.encode("roll", "UTF-8") + "=" + URLEncoder.encode(roll, "UTF-8");

                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return "null ghjgj";

        }


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pd = new ProgressDialog(Files.this);
            pd.setTitle("Loading.");
            pd.setMessage("Please wait...\nLoading Files.");
            pd.setCancelable(false);
            pd.show();
        }

        @Override
        protected void onPostExecute(String result ){

            String json=result;

//            Toast.makeText(Class_routine2.this,""+result,Toast.LENGTH_LONG).show();
            if(result.equalsIgnoreCase("0"))
            {
                ll.setVisibility(View.VISIBLE);

            }
            else if(result.equalsIgnoreCase("10"))
            {

                ll.setVisibility(View.VISIBLE);
                TextView t  = (TextView) findViewById(R.id.file_text);
                t.setText("Sorry Your Attendance is Low");

            }
            pd.dismiss();

            try {

                JSONArray root= new JSONArray(json);

                for(int i=0;i<root.length();i++)
                {
                    JSONObject jsonObject=root.optJSONObject(i);

                    String title= jsonObject.optString("title");
                    String desc=jsonObject.optString("description");
                    String pdf=jsonObject.optString("file");
                    String teacher=jsonObject.optString("t_name");

                    files_class files_class=new files_class(title,pdf,desc,teacher);
                    arrayList.add(files_class);
                }
                adapter.notifyDataSetChanged();
            } catch (JSONException e) {
                e.printStackTrace();
            }


        }



    }

}
