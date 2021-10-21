object FormMain: TFormMain
  Left = 0
  Top = 0
  Caption = 'Lizardry'
  ClientHeight = 712
  ClientWidth = 1184
  Color = clBtnFace
  Constraints.MinHeight = 750
  Constraints.MinWidth = 1200
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  WindowState = wsMaximized
  OnCreate = FormCreate
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  inline FrameLogin: TFrameLogin
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 0
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 712
      inherited CurrentClientVersion: TLabel
        Top = 695
        ExplicitTop = 695
      end
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 712
      ExplicitWidth = 934
      ExplicitHeight = 712
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 734
          ExplicitHeight = 487
        end
      end
      inherited Panel4: TPanel
        Width = 924
        Height = 487
        ExplicitWidth = 924
        ExplicitHeight = 487
        inherited Label3: TLabel
          Width = 924
        end
        inherited Panel5: TPanel
          Width = 924
          ExplicitWidth = 924
        end
        inherited StaticText1: TStaticText
          Width = 924
          Height = 445
          ExplicitWidth = 924
          ExplicitHeight = 445
        end
      end
      inherited Panel6: TPanel
        Height = 487
        ExplicitHeight = 487
      end
    end
  end
  inline FrameRegistration: TFrameRegistration
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 1
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 712
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 712
      ExplicitWidth = 934
      ExplicitHeight = 712
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 734
          ExplicitHeight = 487
        end
      end
      inherited Panel4: TPanel
        Width = 934
        Height = 487
        ExplicitWidth = 934
        ExplicitHeight = 487
      end
    end
  end
  inline FrameTown: TFrameTown
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited RightPanel: TPanel
      Left = 904
      Height = 712
      ExplicitLeft = 904
      ExplicitHeight = 712
    end
    inherited LeftPanel: TPanel
      Height = 712
      ExplicitHeight = 712
    end
    inherited MainPanel: TPanel
      Width = 624
      Height = 712
      ExplicitWidth = 624
      ExplicitHeight = 712
      inherited FrameChat: TFrameChat
        Width = 624
        Height = 487
        ExplicitWidth = 624
        ExplicitHeight = 487
        inherited Panel1: TPanel
          Top = 455
          Width = 624
          ExplicitTop = 455
          ExplicitWidth = 624
          inherited edChatMsg: TEdit
            Width = 622
            ExplicitWidth = 622
          end
        end
        inherited Panel2: TPanel
          Width = 624
          Height = 455
          ExplicitWidth = 624
          ExplicitHeight = 455
          inherited RichEdit1: TRichEdit
            Width = 622
            Height = 453
            ExplicitWidth = 622
            ExplicitHeight = 453
          end
        end
      end
      inherited Panel10: TPanel
        Width = 624
        ExplicitWidth = 624
        inherited bbChat: TSpeedButton
          Left = 535
          ExplicitLeft = 535
        end
      end
      inherited FramePanel: TPanel
        Top = 512
        Width = 624
        ExplicitTop = 512
        ExplicitWidth = 624
        inherited FrameBank1: TFrameBank
          Width = 622
          ExplicitWidth = 622
        end
        inherited FrameDefault1: TFrameDefault
          Width = 622
          ExplicitWidth = 622
        end
        inherited FrameTavern1: TFrameTavern
          Width = 622
          ExplicitWidth = 622
        end
        inherited FrameOutlands1: TFrameOutlands
          Width = 622
          ExplicitWidth = 622
        end
      end
      inherited Panel19: TPanel
        Width = 624
        Height = 487
        ExplicitWidth = 624
        ExplicitHeight = 487
        inherited FrameShop1: TFrameShop
          Width = 622
          Height = 485
          ExplicitWidth = 622
          ExplicitHeight = 485
          inherited Label1: TLabel
            Width = 622
            Height = 160
            ExplicitWidth = 622
            ExplicitHeight = 195
          end
          inherited Slot0: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited Panel2: TPanel
              Left = -1
              Width = 622
              ExplicitLeft = -1
              ExplicitTop = 1
              ExplicitWidth = 622
              ExplicitHeight = 33
              inherited Panel3: TPanel
                Left = 355
                ExplicitLeft = 355
                ExplicitTop = 0
                ExplicitHeight = 33
              end
              inherited pnShopItemValueName: TPanel
                Left = 444
                ExplicitLeft = 444
                ExplicitTop = 0
              end
              inherited Panel6: TPanel
                Left = 525
                ExplicitLeft = 525
                ExplicitTop = 0
                ExplicitHeight = 33
              end
            end
          end
          inherited Slot5: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited pnItemSlot5Name: TPanel
              Width = 620
              ExplicitWidth = 620
              inherited Panel9: TPanel
                Left = 320
                ExplicitLeft = 320
                ExplicitTop = 0
                ExplicitHeight = 33
                inherited pnItemSlot5Level: TPanel
                  Left = 203
                  ExplicitLeft = 203
                  ExplicitTop = 0
                end
                inherited pnItemSlot5Price: TPanel
                  Left = 33
                  ExplicitLeft = 33
                  ExplicitTop = 0
                end
                inherited pnItemSlot5Value: TPanel
                  Left = 122
                  ExplicitLeft = 122
                  ExplicitTop = 0
                end
              end
            end
          end
          inherited Slot1: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited pnItemSlot1Name: TPanel
              Width = 620
              ExplicitWidth = 620
              inherited Panel4: TPanel
                Left = -2
                Width = 622
                ExplicitLeft = -2
                ExplicitTop = 0
                ExplicitWidth = 622
                ExplicitHeight = 33
                inherited pnItemSlot1Level: TPanel
                  Left = 525
                  ExplicitLeft = 525
                  ExplicitTop = 0
                end
                inherited pnItemSlot1Price: TPanel
                  Left = 355
                  ExplicitLeft = 355
                  ExplicitTop = 0
                end
                inherited pnItemSlot1Value: TPanel
                  Left = 444
                  ExplicitLeft = 444
                  ExplicitTop = 0
                  ExplicitHeight = 33
                end
              end
            end
          end
          inherited Slot4: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited pnItemSlot4Name: TPanel
              Width = 620
              ExplicitWidth = 620
              inherited Panel8: TPanel
                Left = -2
                Width = 622
                ExplicitLeft = -2
                ExplicitTop = 0
                ExplicitWidth = 622
                ExplicitHeight = 33
                inherited pnItemSlot4Level: TPanel
                  Left = 525
                  ExplicitLeft = 525
                  ExplicitTop = 0
                end
                inherited pnItemSlot4Price: TPanel
                  Left = 355
                  ExplicitLeft = 355
                  ExplicitTop = 0
                end
                inherited pnItemSlot4Value: TPanel
                  Left = 444
                  ExplicitLeft = 444
                  ExplicitTop = 0
                end
              end
            end
          end
          inherited Slot3: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited pnItemSlot3Name: TPanel
              Width = 620
              ExplicitWidth = 620
              inherited Panel7: TPanel
                Left = 285
                ExplicitLeft = 285
                ExplicitTop = 0
                ExplicitHeight = 33
                inherited pnItemSlot3Level: TPanel
                  Left = 238
                  ExplicitLeft = 238
                  ExplicitTop = 0
                end
                inherited pnItemSlot3Price: TPanel
                  Left = 68
                  ExplicitLeft = 68
                  ExplicitTop = 0
                end
                inherited pnItemSlot3Value: TPanel
                  Left = 157
                  ExplicitLeft = 157
                  ExplicitTop = 0
                end
              end
            end
          end
          inherited Slot2: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited pnItemSlot2Name: TPanel
              Width = 620
              ExplicitWidth = 620
              inherited Panel5: TPanel
                Left = -2
                Width = 622
                ExplicitLeft = -2
                ExplicitTop = 0
                ExplicitWidth = 622
                ExplicitHeight = 33
                inherited pnItemSlot2Price: TPanel
                  Left = 355
                  ExplicitLeft = 355
                  ExplicitTop = 0
                end
                inherited pnItemSlot2Level: TPanel
                  Left = 525
                  ExplicitLeft = 525
                  ExplicitTop = 0
                end
                inherited pnItemSlot2Value: TPanel
                  Left = 444
                  ExplicitLeft = 444
                  ExplicitTop = 0
                end
              end
            end
          end
          inherited DescrPanel: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited lbShopDescr: TLabel
              Width = 620
            end
          end
          inherited Slot6: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited pnItemSlot6Name: TPanel
              Width = 620
              ExplicitWidth = 620
              inherited Panel10: TPanel
                Left = 320
                ExplicitLeft = 320
                ExplicitTop = 0
                ExplicitHeight = 33
                inherited pnItemSlot6Level: TPanel
                  Left = 33
                  ExplicitLeft = 33
                  ExplicitTop = 0
                end
                inherited pnItemSlot6Price: TPanel
                  Left = 211
                  ExplicitLeft = 211
                  ExplicitTop = 0
                end
                inherited pnItemSlot6Value: TPanel
                  Left = 130
                  ExplicitLeft = 130
                  ExplicitTop = 0
                end
              end
            end
          end
        end
        inherited FrameInfo1: TFrameInfo
          Width = 622
          Height = 485
          ExplicitWidth = 622
          ExplicitHeight = 485
          inherited StaticText2: TStaticText
            Top = 351
            Width = 622
            ExplicitTop = 351
            ExplicitWidth = 622
          end
          inherited StaticText1: TStaticText
            Width = 622
            Height = 351
            ExplicitWidth = 622
            ExplicitHeight = 351
          end
        end
        inherited FrameLoot1: TFrameLoot
          Width = 622
          Height = 485
          ExplicitWidth = 622
          ExplicitHeight = 485
        end
        inherited FrameBattle1: TFrameBattle
          Width = 622
          Height = 485
          ExplicitWidth = 622
          ExplicitHeight = 485
          inherited Panel1: TPanel
            Width = 622
            Height = 348
            ExplicitWidth = 622
            ExplicitHeight = 348
            inherited RichEdit1: TRichEdit
              Width = 620
              Height = 346
              ExplicitWidth = 620
              ExplicitHeight = 346
            end
          end
          inherited Panel2: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited Panel3: TPanel
              Left = 284
              ExplicitLeft = 284
            end
          end
        end
      end
    end
  end
end
